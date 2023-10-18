// Get all input elements with data-type="currency"
const currencyInputs = document.querySelectorAll('input[data-type="currency"]');

currencyInputs.forEach((input) => {
    input.addEventListener("keyup", function () {
        formatCurrency(this);
    });

    input.addEventListener("blur", function () {
        formatCurrency(this, "blur");
    });
});

function formatNumber(n) {
    return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function formatCurrency(input, blur) {
    let input_val = input.value;
    if (input_val === "") {
        return;
    }
    const original_len = input_val.length;
    const caret_pos = input.selectionStart;
    if (input_val.indexOf(".") >= 0) {
        const decimal_pos = input_val.indexOf(".");
        let left_side = input_val.substring(0, decimal_pos);
        let right_side = input_val.substring(decimal_pos);
        left_side = formatNumber(left_side);
        right_side = formatNumber(right_side);

        if (blur === "blur") {
            right_side += "00";
        }
        right_side = right_side.substring(0, 2);
        input_val = "Rp " + left_side + "." + right_side;
    } else {
        input_val = formatNumber(input_val);
        input_val = "Rp " + input_val;
        if (blur === "blur") {
            input_val += ".00";
        }
    }

    input.value = input_val;
    const updated_len = input_val.length;
    const new_caret_pos = updated_len - original_len + caret_pos;
    input.setSelectionRange(new_caret_pos, new_caret_pos);
}
