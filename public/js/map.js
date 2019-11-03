class GameMap {
    constructor(map, border, decorations, hidingTrees, hidingStumps, items) {
        this.map = map;
        this.border = border;
        this.decorations = decorations;
        this.hidingTrees = hidingTrees;
        this.hidingStumps = hidingStumps;
        this.items = items;
        this.tileset = {};
        this.kadoc = {};
        this.poulette = {};
        this.score = 0;
        this.canvas = {};
        this.context = null;
        this.getTileset();
    }
    
    getTileset() {
        this.tileset.image = document.createElement('img');
        this.tileset.image.src = 'game/tilesets/rpg.png';
        this.tileset.image.width = 256;
        this.tileset.image.height = 4256;

        // largeur du tileset en tiles
        this.tileset.largeur = this.tileset.image.width / 32;

        this.createKadoc();
    }

    createKadoc() {
        this.kadoc.image = document.createElement('img');
        this.kadoc.image.src = 'game/sprites/exemple.png';
        this.kadoc.image.width = 128;
        this.kadoc.image.height = 192;

        this.kadoc.largeur = this.kadoc.image.width / 4;
        this.kadoc.hauteur = this.kadoc.image.height / 4;

        this.kadoc.x = 0;
        this.kadoc.y = 9;

        this.kadoc.direction = 0;

        this.animationDuration = 4;
        this.travelTime = 15;
        this.animationState = -1;

        this.createPoulette();
    }

    createPoulette() {
        this.poulette.image = document.createElement('img');
        this.poulette.image.src = 'game/sprites/poulette.png';
        this.poulette.image.width = 96;
        this.poulette.image.height = 128;

        this.poulette.largeur = this.poulette.image.width / 3;
        this.poulette.hauteur = this.poulette.image.height / 4;

        this.poulette.direction = 2;
        let getRandomDirection = () => {
            this.poulette.direction = Math.floor(Math.random() * Math.floor(4));
        }
        this.intervalId = setInterval(getRandomDirection, 1000);

        this.poulette.position = Math.floor(Math.random() * Math.floor(3));
        if (this.poulette.position == 0) {
            this.poulette.x = 13;
            this.poulette.y = 5;
        }
        else if (this.poulette.position == 1) {
            this.poulette.x = 14;
            this.poulette.y = 18;
        }
        else {
            this.poulette.x = 22;
            this.poulette.y = 10;
        }

        this.getCanvas();
    }

    getCanvas() {
        this.canvas = document.getElementById("canvas-game");        
        this.context = this.canvas.getContext('2d');

        this.canvas.width = this.map[0].length * 32;
        this.canvas.height = this.map.length * 32;

        this.randomiseItems();
        this.openingScreen();
        this.fillMap();
    }

    randomiseItems() {
        this.randomNum = [];
        this.itemPoints = [];
        this.randomX = [];
        this.randomY = [];

        for (let i = 0; i < this.items.length; i++) {
            let rNumber = Math.floor(Math.random() * Math.floor(3));
            if (rNumber == 0) {
                this.randomNum.push(this.items[i][0]);
                this.itemPoints.push(this.items[i][3]);
            } else if (rNumber == 1) {
                this.randomNum.push(this.items[i][1]);
                this.itemPoints.push(this.items[i][4]);
            } else {
                this.randomNum.push(this.items[i][2]);
                this.itemPoints.push(this.items[i][5]);
            }
            let randomPosition = Math.floor(Math.random() * Math.floor(3));
            if (randomPosition == 0) {
                this.randomX.push(this.items[i][6]);
                this.randomY.push(this.items[i][9]);
            } else if (randomPosition == 1) {
                this.randomX.push(this.items[i][7]);
                this.randomY.push(this.items[i][10]);
            } else {
                this.randomX.push(this.items[i][8]);
                this.randomY.push(this.items[i][11]);
            }
        }
    }

    openingScreen() {
        this.screen = document.getElementById('canvas-div');

        this.filter = document.createElement('div');
        this.filter.id = 'filter';
        this.screen.appendChild(this.filter);

        this.startDiv = document.createElement('div');
        this.startDiv.id = 'startDiv';
        this.screen.appendChild(this.startDiv);

        this.startInfo = document.createElement('p');
        this.startInfo.textContent = 'Prêt ? Appuyez sur START pour commencer';

        this.startButton = document.createElement('input');
        this.startButton.type = 'button';
        this.startButton.value = 'START';
        this.startButton.id = 'startButton';

        this.startDiv.appendChild(this.startInfo);
        this.startDiv.appendChild(this.startButton);

        this.loadSounds();
    }

    loadSounds() {
        this.soundDiv = document.getElementById('game-sounds');

        this.akadoc = document.createElement('audio');
        this.akadoc.src = 'public/sound/a_kadoc.mp3';
        this.akadoc.id = 'akadoc';
        this.soundDiv.appendChild(this.akadoc);

        this.rendez = document.createElement('audio');
        this.rendez.src = 'public/sound/rendez_la_poulette.mp3';
        this.rendez.id = 'rendez';
        this.soundDiv.appendChild(this.rendez);

        this.canard = document.createElement('audio');
        this.canard.src = 'public/sound/canard.mp3';
        this.canard.id = 'canard';
        this.soundDiv.appendChild(this.canard);

        this.poisson = document.createElement('audio');
        this.poisson.src = 'public/sound/poisson.mp3';
        this.poisson.id = 'poisson';
        this.soundDiv.appendChild(this.poisson);

        this.pigeons = document.createElement('audio');
        this.pigeons.src = 'public/sound/pigeons.mp3';
        this.pigeons.id = 'pigeons';
        this.soundDiv.appendChild(this.pigeons);

        this.compote = document.createElement('audio');
        this.compote.src = 'public/sound/compote.mp3';
        this.compote.id = 'compote';
        this.soundDiv.appendChild(this.compote);

        this.startGame();
    }

    startGame() {
        this.rendez.play();
        let onStartClick = () => {
            $(this.filter).css({
                display : 'none'
            });
            $(this.startDiv).css({
                visibility : 'hidden'
            });
            this.startChrono(2, 0);
            this.keyboardUse();
        }
        $('#startButton').on('click', onStartClick);
    }

    startChrono(minute, seconde) {
        this.timer = document.getElementById('hud-timer');
        let tick = () => {
            this.timer.textContent = 'Temps restant  ' + minute + ' : ' + seconde;
            if (seconde >= 0) {
                seconde--;
            }
            if (seconde < 0) {
                minute--;
                seconde = 59;
            }
            if ((minute === 0) && (seconde === 0)) {
                this.timer.textContent = 'Temps restant  0 : 0';
                let randomQuote = Math.floor(Math.random() * Math.floor(3));
                if (randomQuote == 0) {
                    this.randomSound = this.compote;
                }
                else if (randomQuote == 1) {
                    this.randomSound = this.poisson;
                }
                else {
                    this.randomSound = this.pigeons;
                }
                this.randomSound.play();
                this.endGame();
            }
            this.remainingMinute = minute;
            this.remainingSeconde = seconde;
        }
        this.timerInterval = setInterval(tick, 1000);
    }

    endGame() {
        clearInterval(this.timerInterval);
        $('#canvas-game').css({
            opacity : 0
        });
        $('#hud').css({
            opacity : 0
        });
        this.endingScreen();
        setTimeout( () => {
            $('#endDiv').css({
                opacity : 1
            });
        }, 1500);
    }

    endingScreen() {
        this.endDiv = document.createElement('div');
        this.endDiv.id = 'endDiv';
        this.screen.appendChild(this.endDiv);

        this.endInfo = document.createElement('p');
        this.endInfo.textContent = 'Fin de la partie !';

        this.endScore = document.createElement('p');
        this.endScore.textContent = 'Votre score : ' + this.score;

        this.endRemainingTime = document.createElement('p');
        this.endRemainingTime.textContent = ((this.remainingMinute * 60) + this.remainingSeconde) + ' secondes restantes = ' + Math.floor(((this.remainingMinute * 60) + this.remainingSeconde)/2) + ' points supplémentaires';

        this.playerScore = this.score + (this.remainingMinute * 30) + Math.floor(this.remainingSeconde * 0.5);

        this.endScoreTotal = document.createElement('p');
        this.endScoreTotal.id = 'endScoreTotal';
        this.endScoreTotal.textContent = 'Score total : ' + this.playerScore;

        this.endDiv.appendChild(this.endInfo);
        this.endDiv.appendChild(this.endScore);
        this.endDiv.appendChild(this.endRemainingTime);
        this.endDiv.appendChild(this.endScoreTotal);
        

        // ------------------ 

        this.form = document.createElement('form');
        this.form.action = "index.php?action=saveScorePlay";
        this.form.method = 'post';
        this.endDiv.appendChild(this.form);

        this.inputScore = document.createElement('input');
        this.inputScore.type = 'hidden';
        this.inputScore.id = 'score';
        this.inputScore.name = 'score';
        this.inputScore.value = this.playerScore;
        
        this.form.appendChild(this.inputScore);


        this.inputSubmit = document.createElement('input');
        this.inputSubmit.type = 'submit';
        this.inputSubmit.value = 'Enregistrer et rejouer';
        this.inputSubmit.id = 'saveButton';
        this.form.appendChild(this.inputSubmit);

        // -----------------------

        this.exitForm = document.createElement('form');
        this.exitForm.action = "index.php?action=saveScoreList";
        this.exitForm.method = 'post';
        this.endDiv.appendChild(this.exitForm);

        this.exitInputScore = document.createElement('input');
        this.exitInputScore.type = 'hidden';
        this.exitInputScore.id = 'score';
        this.exitInputScore.name = 'score';
        this.exitInputScore.value = this.playerScore;
        
        this.exitForm.appendChild(this.exitInputScore);


        this.exitInputSubmit = document.createElement('input');
        this.exitInputSubmit.type = 'submit';
        this.exitInputSubmit.value = 'Enregistrer et voir les scores';
        this.exitInputSubmit.id = 'exitSaveButton';
        this.exitForm.appendChild(this.exitInputSubmit);

    }

    keyboardUse() {
        document.addEventListener('keydown', (event) => {
        let key = event.keyCode;
        switch(key) {
            case 38 : case 122 : case 119 : case 90 : case 87 : // Flèche haut, z, w, Z, W
                this.moveKadoc(3);
                break;
            case 40 : case 115 : case 83 : // Flèche bas, s, S
                this.moveKadoc(0);
                break;
            case 37 : case 113 : case 97 : case 81 : case 65 : // Flèche gauche, q, a, Q, A
                this.moveKadoc(1);
                break;
            case 39 : case 100 : case 68 : // Flèche droite, d, D
                this.moveKadoc(2);
                break;
            case 32 : case 69 : // Barre espace
                this.action(this.kadoc.direction);
                break;
            default :
            return true;
        }
        });
    }

    fillMap() {
        let draw = () => {
            this.drawMap();
        }
        this.intervalId = setInterval(draw, 40);
    }

    checkNextCase(direction) {
        let coord = {'x' : this.kadoc.x, 'y' : this.kadoc.y};
        switch(direction) {
            case 0 :
                coord.y++;
                break;
            case 1 :
                coord.x--;
                break;
            case 2 :
                coord.x++;
                break;
            case 3 :
                coord.y--;
                break;
        }
        return coord;
    }

    moveKadoc(direction) {
        if (this.animationState >= 0) {
            return false;
        }

        this.kadoc.direction = direction;

        let nextCase = this.checkNextCase(direction);
        if (nextCase.x < 0 || nextCase.y < 1 || nextCase.x >= this.map[0].length || nextCase.y >= this.map.length) {
            return false;
        }
        let a = this.decorations[nextCase.y][nextCase.x];
        let b = this.border[nextCase.y][nextCase.x];
        if (a == 17 || a == 18 || a == 25 || a == 26 || a == 33 || a == 34 || a == 41 || a == 47 || a == 48 || a == 64 || a == 66 || a == 72 || b == 81 || b == 89 || b == 97 || b == 98 || b == 105 || b == 106) {
            return false;
        }
        if (nextCase.x == this.poulette.x && nextCase.y == this.poulette.y) {
            return false;
        }
        
        this.animationState = 1;

        this.kadoc.x = nextCase.x;
        this.kadoc.y = nextCase.y;

        return true;
    }

    action(direction) {
        let nextCase = this.checkNextCase(direction);
        let hudScore = document.getElementById('hud-score');

        if (nextCase.x == this.poulette.x && nextCase.y == this.poulette.y) {
            this.canard.play();
            this.score += 50;
            hudScore.textContent = 'Score : ' + this.score;
            this.endGame();
        }
        for (let i = 0; i < this.items.length; i++) {
            if ((nextCase.x == this.randomX[i] && nextCase.y == this.randomY[i]) || (this.kadoc.x == this.randomX[i] && this.kadoc.y == this.randomY[i])) {
                this.akadoc.play();
                this.randomX[i] = -1;
                this.randomY[i] = -1;
                this.score += this.itemPoints[i];
                hudScore.textContent = 'Score : ' + this.score;
            }
        }
    }

    // Fonctions de dessin -> drawMap est en bas.

    drawTile(numero, xDestination, yDestination) {        
        let xSourceEnTiles = numero % this.tileset.largeur;
        if (xSourceEnTiles == 0) {
            xSourceEnTiles = this.tileset.largeur;
        }

        let ySourceEnTiles = Math.ceil(numero / this.tileset.largeur);

        let xSource = (xSourceEnTiles - 1) * 32;
        let ySource = (ySourceEnTiles - 1) * 32;

        this.context.drawImage(this.tileset.image, xSource, ySource, 32, 32, xDestination, yDestination, 32, 32);        
    }

    drawPoulette() {
        this.context.drawImage(
            this.poulette.image,
            this.poulette.largeur, this.poulette.direction * this.poulette.hauteur,
            32, 32,
            (this.poulette.x * 32) + 3, (this.poulette.y * 32) + 3,
            16, 16
        );
    }

    drawKadoc() {
        let frame = 0;
        let shiftX = 0;
        let shiftY = 0;

        if (this.animationState >= this.travelTime) {
            this.animationState = -1;
        }
        else if (this.animationState >= 0) {
            frame = Math.floor(this.animationState / this.animationDuration);
            if (frame > 3) {
                frame %= 4;
            }

            let travelDistance = 32 - (32 * (this.animationState / this.travelTime));

            if (this.kadoc.direction == 3) {
                shiftY = travelDistance;
            } else if (this.kadoc.direction == 0) {
                shiftY = -travelDistance;
            } else if (this.kadoc.direction == 1) {
                shiftX = travelDistance;
            } else if (this.kadoc.direction == 2) {
                shiftX = -travelDistance;
            }

            this.animationState++;
        }

        this.context.drawImage(
            this.kadoc.image,
            this.kadoc.largeur * frame, this.kadoc.direction * this.kadoc.hauteur,
            this.kadoc.largeur, this.kadoc.hauteur,
            (this.kadoc.x * 32) - (this.kadoc.largeur / 2) + 16 + shiftX, (this.kadoc.y * 32) - this.kadoc.hauteur + 24 + shiftY,
            this.kadoc.largeur, this.kadoc.hauteur
        );
    }

    drawItems() {
        for (let i = 0; i < this.items.length; i++) {
            this.drawTile(this.randomNum[i], this.randomX[i] * 32, this.randomY[i] * 32);
        }
    }
    
    drawMap() {
        // terrain
        for (let i = 0; i < this.map.length; i++) {
            let line = this.map[i];
            let y = i * 32;
            for (let j = 0; j < line.length; j++) {
                this.drawTile(line[j], j * 32, y);
            }
        }
        // bordures et falaises
        for (let i = 0; i < this.border.length; i++) {
            let line = this.border[i];
            let y = i * 32;
            for (let j = 0; j < line.length; j++) {
                this.drawTile(line[j], j * 32, y);
            }
        }
        // décors
        for (let i = 0; i < this.decorations.length; i++) {
            let line = this.decorations[i];
            let y = i * 32;
            for (let j = 0; j < line.length; j++) {
                this.drawTile(line[j], j * 32, y);
            }
        }
        // la poulette qui sera bien cachée par le décors
        this.drawPoulette();
        // les objets à ramasser
        this.drawItems();
        
        // les souches d'arbres qui cachent la poulette et les objets mais pas Kadoc
        for (let i = 0; i < this.hidingStumps.length; i++) {
            let line = this.hidingStumps[i];
            let y = i * 32;
            for (let j = 0; j < line.length; j++) {
                this.drawTile(line[j], j * 32, y);
            }
        }
        // À Kadoc !
        this.drawKadoc();
        // décors qui cachent le perso
        for (let i = 0; i < this.hidingTrees.length; i++) {
            let line = this.hidingTrees[i];
            let y = i * 32;
            for (let j = 0; j < line.length; j++) {
                this.drawTile(line[j], j * 32, y);
            }
        }
    } 
}