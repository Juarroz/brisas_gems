const BASE_URL = document.querySelector("body").getAttribute("data-base-url") || "";

// Estado de selección
let seleccion = {};

// Construir ruta de vistas dinámicas (solo gema, forma y material)
function rutaVista(valores, vista) {
  // valores[0] = gema, valores[1] = forma, valores[2] = material
  return `${BASE_URL}/assets/img/personalizacionproductos/vistas-anillos/${valores[0]}/${valores[1]}/${valores[2]}/${vista}.jpg`;
}

// Manejar cambio de vista (miniaturas)
function cambiarVista(imagen) {
  const principal = document.getElementById("vista-principal");
  if (principal) {
    principal.src = imagen.src;
    principal.alt = imagen.alt;
  }
}
window.cambiarVista = cambiarVista;

// Al cargar
document.addEventListener("DOMContentLoaded", () => {
  // Para cada grupo de botones
  document.querySelectorAll("[id^='grupo-']").forEach(grupo => {
    const slug = grupo.id.replace("grupo-", "");
    seleccion[slug] = "";

    grupo.querySelectorAll("button").forEach(btn => {
      btn.addEventListener("click", () => {
        grupo.querySelectorAll("button").forEach(b => b.classList.remove("active"));
        btn.classList.add("active");
        seleccion[slug] = btn.dataset.valor;

        // Actualizar hidden input
        const hidden = document.getElementById("f-" + slug);
        if (hidden) hidden.value = seleccion[slug];

        actualizarVistas();
      });
    });

    // Inicializar con el primer valor activo
    const activo = grupo.querySelector(".active");
    if (activo) {
      seleccion[slug] = activo.dataset.valor;
      const hidden = document.getElementById("f-" + slug);
      if (hidden) hidden.value = seleccion[slug];
    }
  });

  // Actualizar al inicio
  actualizarVistas();
});

// Cambiar imágenes de vista previa
function actualizarVistas() {
  const valores = Object.values(seleccion);

  // Necesitamos al menos gema, forma y material para mostrar vistas
  if (!valores[0] || !valores[1] || !valores[2]) return;

  ["superior", "frontal", "perfil"].forEach(v => {
    const img = document.getElementById("vista-" + v);
    if (img) img.src = rutaVista(valores, v);
  });

  const principal = document.getElementById("vista-principal");
  if (principal) principal.src = rutaVista(valores, "superior");
}
