function lerpColor(color1, color2, t) {
    // Convert hexadecimal color to RGB format
    function hexToRgb(hex) {
        const bigint = parseInt(hex.slice(1), 16);
        const r = (bigint >> 16) & 255;
        const g = (bigint >> 8) & 255;
        const b = bigint & 255;
        return [r, g, b];
    }

    // Convert RGB color to hexadecimal format
    function rgbToHex(rgb) {
        return (
            "#" +
            ((1 << 24) + (rgb[0] << 16) + (rgb[1] << 8) + rgb[2])
                .toString(16)
                .slice(1)
        );
    }

    const rgb1 = hexToRgb(color1);
    const rgb2 = hexToRgb(color2);

    const r = Math.round(rgb1[0] * (1 - t) + rgb2[0] * t);
    const g = Math.round(rgb1[1] * (1 - t) + rgb2[1] * t);
    const b = Math.round(rgb1[2] * (1 - t) + rgb2[2] * t);

    return rgbToHex([r, g, b]);
}

const backgroundColorsClean = {
    50: "#f7f7f7",
    100: "#e3e3e3",
    200: "#c8c8c8",
    300: "#a4a4a4",
    400: "#818181",
    500: "#666666",
    600: "#515151",
    700: "#434343",
    800: "#383838",
    900: "#313131",
    950: "#212121",
    1000: "#171717",
};
const keys = Object.keys(backgroundColorsClean);
const newColors = {};
keys.forEach((key1, index) => {
    if (index > keys.length - 2) {
        return;
    }
    const key2 = keys[index + 1];
    const value1 = backgroundColorsClean[key1];
    const value2 = backgroundColorsClean[key2];
    let lerp = lerpColor(value1, value2, 0.5);
    newColors[key1] = value1;
    const lerpKey = parseInt((key2 - key1) / 2) + parseInt(key1);
    newColors[lerpKey] = lerp;
    newColors[key2] = value2;
});
console.log("newColors", newColors);
