class CanvasMap {
    constructor(map, border, decorations) {
        this.map = map;
        this.border = border;
        this.decorations = decorations;
        this.tileset = {};
        this.poulette = {};
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

        this.fillMap();
    }

    fillMap() {
        let draw = () => {
            this.drawMap();
        }
        this.intervalId = setInterval(draw, 40);
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
        this.context.drawImage(this.poulette.image, this.poulette.largeur, this.poulette.hauteur * this.poulette.direction, 32, 32, (this.poulette.x * 32) + 3, (this.poulette.y * 32) + 3, 16, 16);
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
        // la poulette qui sera bien cachée par le décors
        this.drawPoulette();
        // décors
        for (let i = 0; i < this.decorations.length; i++) {
            let line = this.decorations[i];
            let y = i * 32;
            for (let j = 0; j < line.length; j++) {
                this.drawTile(line[j], j * 32, y);
            }
        }
    } 
}