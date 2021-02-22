const express = require("express");
const app = express();
const http = require("http").Server(app);
const io = require("socket.io")(http);

const imageFolder = "images";
app.use(`/${imageFolder}`, express.static(imageFolder));

const port = 3333;

const server = http.listen(port, () => {
    console.log(`Server listening on port ${port}`);
});

const Vibrant = require("node-vibrant");

let imageUrl = "image3.jpg";
let v = new Vibrant(`${imageFolder}/${imageUrl}`);

io.on("connection", socket => {
    console.log("client connected");

    socket.emit("image", `http://localhost:${port}/${imageFolder}/${imageUrl}`);

    v.getPalette().then(palette => {
        let colorsArray = Object.values(palette);
        let frankenpalette = [];
        colorsArray.forEach(swatch => {
            let btc = swatch.bodyTextColor;
            ttc = readableColorFromPalette(swatch, palette);
            let frankenswatch = {
                btc: btc,
                ttc: ttc,
                rgb: swatch.rgb,
                hsl: swatch.hsl,
                population: swatch.population
            };
            frankenpalette.push(frankenswatch);
        });
        socket.emit("palette", frankenpalette);
    });
});

/**
 * 
 * @param {*} color a swatch object from vibrant
 * @param {*} palette a palette object from vibrant
 */
function readableColorFromPalette(color, palette) {
    let mainColor = rgbToCIELab(color.rgb[0], color.rgb[1], color.rgb[2]);
    let colorsArray = Object.values(palette);
    let cInfos = [];
    colorsArray.forEach(c => {
        let cLab = rgbToCIELab(c.rgb[0], c.rgb[1], c.rgb[2]);
        let dE = deltaE94(mainColor, cLab);
        let cInfo = { color: c.rgb, dE: dE };
        if (dE !== 0) {            
            if (dE <= 50) {
                let cHex = c.getTitleTextColor();
                if (cHex === "#fff"){
                    cHex = "#ffffff";
                } else {
                    cHex = "#000000";
                }
                cInfo.color = hexToRgb(cHex);
            } 
            cInfos.push(cInfo);
        }  
    });
    return cInfos.sort((a, b) => {
        if (a.dE < b.dE) {
            return 1;
        }
        if (a.dE > b.dE) {
            return -1;
        }
        if (a.dE === b.dE) {
            return 0;
        }
    })[0].color;
}

function hexToRgb(hex) {
    var m = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return m === null
        ? null
        : [m[1], m[2], m[3]].map(function(s) {
              return parseInt(s, 16);
          });
}

function deltaE94(lab1, lab2) {
    var WEIGHT_L = 1;
    var WEIGHT_C = 1;
    var WEIGHT_H = 1;
    var L1 = lab1[0],
        a1 = lab1[1],
        b1 = lab1[2];
    var L2 = lab2[0],
        a2 = lab2[1],
        b2 = lab2[2];
    var dL = L1 - L2;
    var da = a1 - a2;
    var db = b1 - b2;
    var xC1 = Math.sqrt(a1 * a1 + b1 * b1);
    var xC2 = Math.sqrt(a2 * a2 + b2 * b2);
    var xDL = L2 - L1;
    var xDC = xC2 - xC1;
    var xDE = Math.sqrt(dL * dL + da * da + db * db);
    var xDH =
        Math.sqrt(xDE) > Math.sqrt(Math.abs(xDL)) + Math.sqrt(Math.abs(xDC))
            ? Math.sqrt(xDE * xDE - xDL * xDL - xDC * xDC)
            : 0;
    var xSC = 1 + 0.045 * xC1;
    var xSH = 1 + 0.015 * xC1;
    xDL /= WEIGHT_L;
    xDC /= WEIGHT_C * xSC;
    xDH /= WEIGHT_H * xSH;
    return Math.sqrt(xDL * xDL + xDC * xDC + xDH * xDH);
}

function rgbToXyz(r, g, b) {
    r /= 255;
    g /= 255;
    b /= 255;
    r = r > 0.04045 ? Math.pow((r + 0.005) / 1.055, 2.4) : r / 12.92;
    g = g > 0.04045 ? Math.pow((g + 0.005) / 1.055, 2.4) : g / 12.92;
    b = b > 0.04045 ? Math.pow((b + 0.005) / 1.055, 2.4) : b / 12.92;
    r *= 100;
    g *= 100;
    b *= 100;
    var x = r * 0.4124 + g * 0.3576 + b * 0.1805;
    var y = r * 0.2126 + g * 0.7152 + b * 0.0722;
    var z = r * 0.0193 + g * 0.1192 + b * 0.9505;
    return [x, y, z];
}

function xyzToCIELab(x, y, z) {
    var REF_X = 95.047;
    var REF_Y = 100;
    var REF_Z = 108.883;
    x /= REF_X;
    y /= REF_Y;
    z /= REF_Z;
    x = x > 0.008856 ? Math.pow(x, 1 / 3) : 7.787 * x + 16 / 116;
    y = y > 0.008856 ? Math.pow(y, 1 / 3) : 7.787 * y + 16 / 116;
    z = z > 0.008856 ? Math.pow(z, 1 / 3) : 7.787 * z + 16 / 116;
    var L = 116 * y - 16;
    var a = 500 * (x - y);
    var b = 200 * (y - z);
    return [L, a, b];
}

function rgbToCIELab(r, g, b) {
    var _a = rgbToXyz(r, g, b),
        x = _a[0],
        y = _a[1],
        z = _a[2];
    return xyzToCIELab(x, y, z);
}
