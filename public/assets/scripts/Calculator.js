const display = document.getElementById("display");
const buttons = document.querySelectorAll(".buttons button");
console.log("calc successful");
buttons.forEach(button => {
    button.addEventListener("click", () => {
        const value = button.textContent;

        if (value === "=") {
            try {
                // Replace ^ with ** for exponentiation
                const expression = display.value.replace(/\^/g, "**"); // ^ is another operator in JS, replace it with **
                let result = Function(`return ${expression}`)();

                // Round to 4 decimal places if it's a number
                if (typeof result === "number" && !isNaN(result)) {
                    result = Math.round(result * 10000) / 10000; // There is no float rounding, have to *10000 and /10000 to get to 4 digits

                    result = result.toLocaleString("en-US", { // Every fourth digit is a comma
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 4});
                }

                display.value = result;
            } catch {
                display.value = "Error";
            }
        } else if (value === "Clear"){
            display.value = "";
        } else if (value === "yˣ"){
            display.value += "^";
        }
        else {
            // Append button value to display
            display.value += value;
        }
    });
});