document.addEventListener("DOMContentLoaded", function () {
    // Definir los nombres de los menús y las URLs correspondientes
    var base_urlx = ""; // Supongamos que base_urlx está definido previamente

    var menuItems = [
        { nombre: "Cotizaciones", url: base_urlx + "Altacotizacion", submenu : "Alta cotización" },
        { nombre: "Alta Usuarios", url: base_urlx + "AltaUsuarios", submenu : "Alta usuario y/o departamento" },
        { nombre: "Compras", url: base_urlx, submenu  : "Orden de compra" },
        { nombre: "Compras", url: base_urlx, submenu : "Reporte ODC" },
        { nombre: "Compras", url: base_urlx, submenu : "Asignar Proveedor" },
        { nombre: "Proveedores", url: base_urlx, submenu : "Alta de proveedores" },
        { nombre: "Proveedores", url: base_urlx, submenu : "Reporte de proveedores" },
        { nombre: "Catalogo", url: base_urlx, submenu : "Alta de productos" },
        { nombre: "Catalogo", url: base_urlx, submenu : "Reporte de productos" },
        { nombre: "Catalogo", url: base_urlx, submenu : "Alta de marcas" },
        { nombre: "Catalogo", url: base_urlx, submenu : "Alta de categorias" },
        // Puedes agregar más elementos según sea necesario
    ];

    // Objeto para almacenar los menús y submenús agrupados
    var groupedMenuItems = {};

    // Agrupar los menús y submenús
    menuItems.forEach(function (menuItem) {
        var nombreMenu = menuItem.nombre;
        var url = menuItem.url;
        var submenux = menuItem.submenu;

        // Si el menú aún no está en el objeto agrupado, crear una nueva entrada
        if (!groupedMenuItems[nombreMenu]) {
            groupedMenuItems[nombreMenu] = {
                nombre: nombreMenu,
                submenus: []
            };
        }

        // Agregar el submenú al menú correspondiente
        groupedMenuItems[nombreMenu].submenus.push({ url: url, submenu: submenux });
    });

    // Recorrer los menús agrupados y crear los elementos HTML
    for (var nombreMenu in groupedMenuItems) {
        if (groupedMenuItems.hasOwnProperty(nombreMenu)) {
            var menu = groupedMenuItems[nombreMenu];
            var divMenu = createMenuDiv(menu);
            var enlacesContainer = document.getElementById("row_enlacesContainer");
            enlacesContainer.appendChild(divMenu);
        }
    }
});

// Función para crear el div del menú y sus submenús
function createMenuDiv(menu) {
    var divMenu = document.createElement("div");
    divMenu.classList.add("col-lg-4", "mb-3");

    var h4 = document.createElement("h4");
    h4.classList.add("mt-0", "mb-3", "text-dark", "op-8", "font-weight-bold");
    h4.textContent = menu.nombre;

    var ul = document.createElement("ul");
    ul.classList.add("list-timeline", "list-timeline-primary");

    // Agregar los submenús al menú
    menu.submenus.forEach(function (submenu) {
        var li = document.createElement("li");
        li.classList.add(
            "list-timeline-item",
            "p-0",
            "pb-3",
            "pb-lg-4",
            "d-flex",
            "flex-wrap",
            "flex-column"
        );

        var p = document.createElement("p");
        p.classList.add(
            "my-0",
            "text-dark",
            "flex-fw",
            "text-sm",
            "text-uppercase"
        );

        var span = document.createElement("span");
        span.classList.add("text-inverse", "op-8");
        span.textContent = submenu.url;

        var a = document.createElement("a");
        a.href = submenu.url;
        a.textContent = submenu.submenu;

        p.appendChild(span);
        p.appendChild(document.createTextNode(" - "));
        p.appendChild(a);

        li.appendChild(p);
        ul.appendChild(li);
    });

    divMenu.appendChild(h4);
    divMenu.appendChild(ul);

    return divMenu;
}
