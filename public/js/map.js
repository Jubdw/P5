class CanvasMap {
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
        this.randomNum = [];
        this.itemPoints = [];
        this.randomX = [];
        this.randomY = [];
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
        this.keyboardUse();

        this.fillMap();
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
            case 32 : // Barre espace
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
            alert('Si Kadoc il surveille bien, il aura des ptits cube de fromage.');
            this.poulette.x = -1;
            this.poulette.y = -1;
        }
        for (let i = 0; i < this.items.length; i++) {
            if ((nextCase.x == this.randomX[i] && nextCase.y == this.randomY[i]) || (this.kadoc.x == this.randomX[i] && this.kadoc.y == this.randomY[i])) {
                alert('À Kadoc !');
                this.randomX[i] = -1;
                this.randomY[i] = -1;
                this.score += this.itemPoints[i];
                hudScore.textContent = 'Score : ' + this.score;
            }
        }
    }

    randomiseItems() {
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
            let rX = Math.floor(Math.random() * Math.floor(3));
            if (rX == 0) {
                this.randomX.push(this.items[i][6]);
            } else if (rX == 1) {
                this.randomX.push(this.items[i][7]);
            } else {
                this.randomX.push(this.items[i][8]);
            }
            let rY = Math.floor(Math.random() * Math.floor(3));
            if (rY == 0) {
                this.randomY.push(this.items[i][9]);
            } else if (rY == 1) {
                this.randomY.push(this.items[i][10]);
            } else {
                this.randomY.push(this.items[i][11]);
            }
        }
    }

    // Fonctions de dessin -> drawMap est en bas.

    drawItems() {
        for (let i = 0; i < this.items.length; i++) {
            this.drawTile(this.randomNum[i], this.randomX[i] * 32, this.randomY[i] * 32);
        }
    }

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