class CanvasMap {
    constructor(map) {
        this.map = map;
        this.canvas = {};
        this.context = null;
        this.tileset = {};
        this.getTileset();
    }
    
    getTileset() {
        this.tileset.image = document.createElement('img');
        this.tileset.image.src = 'game/tilesets/rpg.png';
        this.tileset.image.width = 256;
        this.tileset.image.height = 4256;

        // largeur du tileset en tiles
        this.tileset.largeur = this.tileset.image.width / 32;

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
        let dessiner = () => {
            this.drawMap();
        }
        this.intervalId = setInterval(dessiner, 40);
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
    
    drawMap() {
        for (let i = 0; i < this.map.length; i++) {
            let line = this.map[i];
            let y = i * 32;
            for (let j = 0; j < line.length; j++) {
                this.drawTile(line[j], j * 32, y);
            }
        }
    } 
}