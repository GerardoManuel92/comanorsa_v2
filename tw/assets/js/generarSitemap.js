document.addEventListener("DOMContentLoaded", function () {
    // Definir los nombres de los menús y las URLs correspondientes
    var menuItems = [
        { nombre: "Cotizaciones", url: base_urlx + "Altacotizacion"},
        { nombre: "Alta Usuarios", url: base_urlx + "AltaUsuarios" }
        // Puedes agregar más elementos según sea necesario
    ];

    $("#nivel2").html(menuItems);

    // Crea el contenido del archivo XML del sitemap
    var sitemapContent = '<?xml version="1.0" encoding="UTF-8"?>\n';
    sitemapContent += '<urlset xmlns="' + base_urlx + '">\n';

    // Crea un arreglo para almacenar las URLs
    var enlacesArray = [];

    // Recorre cada elemento del menú y agrega una entrada al sitemap y al arreglo
    menuItems.forEach(function (menuItem) {
        var nombreMenu = menuItem.nombre;
        var url = menuItem.url;

        // Verifica si la URL comienza con "http"
        if (url.startsWith("http")) {
            sitemapContent += "    <url>\n";
            sitemapContent += "        <a href='" + url + "'>" + nombreMenu + "</a>\n";
            sitemapContent += "    </url>\n";

            enlacesArray.push(url);

            // Crea un elemento de texto para el nombre del menú
            var nombreMenuElement = document.createElement("span");
            nombreMenuElement.textContent = nombreMenu;

            // Crea un elemento de enlace para la URL
            var enlace = document.createElement("a");
            enlace.href = url;
            enlace.textContent = url;
            enlace.setAttribute("target", "_blank");

            // Agrega los elementos al contenedor enlacesContainer en el HTML
            var enlacesContainer = document.getElementById("enlacesContainer");
            enlacesContainer.appendChild(nombreMenuElement);
            enlacesContainer.appendChild(document.createElement("br")); // Para agregar un salto de línea
            enlacesContainer.appendChild(enlace);
            enlacesContainer.appendChild(document.createElement("br")); // Para agregar un salto de línea
        }
    });

    sitemapContent += "</urlset>";

    // Crea un enlace de descarga para el sitemap
    var blob = new Blob([sitemapContent], { type: "application/xml" });
    var url = URL.createObjectURL(blob);
    var enlaceDescarga = document.createElement("a");
    enlaceDescarga.href = url;
    enlaceDescarga.download = "sitemap.xml";
    enlaceDescarga.innerHTML = "Descargar Sitemap";

    // Agrega el enlace de descarga al cuerpo del documento
    document.body.appendChild(enlaceDescarga);
});
