function afficher(array) {
    var tab = document.getElementById("tab");
    tab.innerText = ""; // Très sale, utilisé uniquement pour une appli de tests !!!
    // Pour récupérer les lignes
    var thead = document.createElement("thead");
    var tbody = document.createElement("tbody");
    for (var i in array) {
        var obj = array[i];
        var row = document.createElement("tr");
        // Pour récupérer les noms des colonnes
        if (i == 0) {
            var rowHead = document.createElement("tr");
            for (var j in obj) {
                var cellHead = document.createElement("th");
                var cellHeadText = document.createTextNode(j);
                cellHead.appendChild(cellHeadText);
                rowHead.appendChild(cellHead)
            }
            thead.appendChild(rowHead);
            tab.appendChild(thead);
        }
        // Pour récupérer les valeurs dans les colonnes
        for (var j in obj) {
            var cell = document.createElement("td");
            var cellText = document.createTextNode(obj[j]);
            cell.appendChild(cellText);
            row.appendChild(cell)
        }
        tbody.appendChild(row);
    }
    tab.appendChild(tbody);
}
