document.addEventListener('DOMContentLoaded', function() {
    const button = document.getElementById('button');
    button.addEventListener('click', CreateUniqueTable);
});

function CreateUniqueTable() {
    const rows = document.getElementById('rows').value;
    const cols = document.getElementById('cols').value;
    const errorDiv = document.getElementById('error');
    const tableContainer = document.getElementById('table');
    
    errorDiv.textContent = '';
    tableContainer.innerHTML = '';
    
    if (rows === '' || cols === '') {
        errorDiv.textContent = 'enter both rows and columns';
        return;
    }
    
    if (rows < 1 || cols < 1) {
        errorDiv.textContent = 'enter positive numbers for rows and columns';
        return;
    }
    
    const table = document.createElement('table');
    
    for (let i = 0; i < rows; i++) {
        const tr = document.createElement('tr');
        
        for (let j = 0; j < cols; j++) {
            const td = document.createElement('td');
            td.textContent = `area ${i+1},${j+1}`;
            tr.appendChild(td);
        }
        
        table.appendChild(tr);
    }
    
    tableContainer.appendChild(table);
}
