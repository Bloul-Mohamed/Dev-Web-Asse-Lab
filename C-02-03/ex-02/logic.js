document.addEventListener('DOMContentLoaded', function() {
    const calculatorForm = document.getElementById('calculatorForm');
    const firstNumberInput = document.getElementById('firstNumber');
    const secondNumberInput = document.getElementById('secondNumber');
    const operationSelect = document.getElementById('operation');
    const calculateBtn = document.getElementById('calculateBtn');
    const resultDisplay = document.getElementById('result');
    
    calculateBtn.addEventListener('click', performCalculation);
    
    calculatorForm.addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            performCalculation();
        }
    });
    
    function performCalculation() {
        const firstNumber = parseFloat(firstNumberInput.value);
        const secondNumber = parseFloat(secondNumberInput.value);
        const operation = operationSelect.value;
        
        if (isNaN(firstNumber) || isNaN(secondNumber)) {
            resultDisplay.textContent = 'Please enter valid numbers';
            resultDisplay.style.color = '#e74c3c';
            return;
        }
        
        let result;
        let operationSymbol;
        
        switch (operation) {
            case 'add':
                result = firstNumber + secondNumber;
                operationSymbol = '+';
                break;
            case 'subtract':
                result = firstNumber - secondNumber;
                operationSymbol = '-';
                break;
            case 'multiply':
                result = firstNumber * secondNumber;
                operationSymbol = '×';
                break;
            case 'divide':
                if (secondNumber === 0) {
                    resultDisplay.textContent = 'Cannot divide by zero';
                    resultDisplay.style.color = '#e74c3c';
                    return;
                }
                result = firstNumber / secondNumber;
                operationSymbol = '÷';
                break;
            default:
                resultDisplay.textContent = 'Invalid operation';
                return;
        }
        
        result = Number.isInteger(result) ? result : result.toFixed(2);
        resultDisplay.textContent = `${firstNumber} ${operationSymbol} ${secondNumber} = ${result}`;
        resultDisplay.style.color = '#333';
    }
});
