function getTipoMovimiento(id){
        switch (id){
            case "O":
                return "Apertura de Caja";
            case "A":
                return "Ingreso de Apuesta";
            case "I":
                return "Pago de Apuesta";
            case "D":
                return "Dep. Cta Existente";
            case "R":
                return "Ret. Cta Existente";
            case "B":
                return "Deposito a Caja";
            case "F":
                return "Retiro a Caja";
            case "E":
                return "Incremento de Efectivo";
            case "C":
                return "Cierre de Caja";
            case "J":
                return "Borrado de Apuesta";
        }
    }
    
    
    function exportToExcel(tableId){
    $("#"+tableId).table2excel({
            exclude: ".noExl",
            name: "Excel Document Name",
            filename: tableId,
            fileext: ".xls",
            exclude_img: true,
            exclude_links: true,
            exclude_inputs: true
    });
}