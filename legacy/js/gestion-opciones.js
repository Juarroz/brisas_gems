// js/gestion-opciones.js
// Lógica para gestión de opciones de personalización en admin

document.addEventListener('DOMContentLoaded', function() {
    cargarOpciones();

    // Mostrar modal para agregar opción
    document.getElementById('btn-agregar-opcion').addEventListener('click', function() {
        limpiarModal();
        document.getElementById('modalOpcionLabel').textContent = 'Agregar Opción';
        new bootstrap.Modal(document.getElementById('modalOpcion')).show();
    });

    // Vista previa y validación de imagen
    document.getElementById('imagen_opcion').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('preview-imagen-opcion');
        const errorDiv = document.getElementById('error-imagen-opcion');
        if (file) {
            if (!['image/png', 'image/jpeg'].includes(file.type)) {
                errorDiv.textContent = 'Solo se permiten imágenes PNG o JPG.';
                errorDiv.style.display = 'block';
                preview.classList.add('d-none');
                e.target.value = '';
                return;
            }
            if (file.size > 2 * 1024 * 1024) {
                errorDiv.textContent = 'La imagen no debe superar los 2MB.';
                errorDiv.style.display = 'block';
                preview.classList.add('d-none');
                e.target.value = '';
                return;
            }
            errorDiv.textContent = '';
            errorDiv.style.display = 'none';
            const reader = new FileReader();
            reader.onload = function(ev) {
                preview.src = ev.target.result;
                preview.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        } else {
            preview.classList.add('d-none');
            errorDiv.textContent = '';
            errorDiv.style.display = 'none';
        }
    });

    // Guardar opción (agregar o editar)
    document.getElementById('form-opcion').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        const opcionId = formData.get('opcion_id');
        const url = opcionId ? '../php/personalizacion/editar_opcion.php' : '../php/personalizacion/agregar_opcion.php';
        fetch(url, {
            method: 'POST',
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                bootstrap.Modal.getInstance(document.getElementById('modalOpcion')).hide();
                cargarOpciones();
            } else {
                // Mostrar error en el modal, no solo alert
                const errorDiv = document.getElementById('error-imagen-opcion');
                errorDiv.textContent = data.error || 'Error al guardar';
                errorDiv.style.display = 'block';
            }
        });
    });
});

function cargarOpciones() {
    fetch('../php/personalizacion/listar_opciones_admin.php')
        .then(r => r.json())
        .then(data => {
            const tbody = document.querySelector('#tabla-opciones tbody');
            tbody.innerHTML = '';
            data.opciones.forEach(op => {
                const tr = document.createElement('tr');
                let imgSrc = op.opc_imagen ? op.opc_imagen : '../img/gem.svg';
                tr.innerHTML = `
                    <td>${op.opc_nombre}</td>
                    <td><img src="${imgSrc}" class="img-preview" alt="Imagen opción"></td>
                    <td>${op.opc_descripcion || ''}</td>
                    <td>
                        <button class="btn btn-sm btn-primary me-1" onclick="editarOpcion(${op.opc_id}, '${op.opc_nombre.replace(/'/g, "\'")}', '${(op.opc_descripcion||'').replace(/'/g, "\'")}', '${op.opc_imagen || ''}')"><i class="bi bi-pencil"></i></button>
                        <button class="btn btn-sm btn-danger" onclick="eliminarOpcion(${op.opc_id})"><i class="bi bi-trash"></i></button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        });
}

function limpiarModal() {
    document.getElementById('opcion_id').value = '';
    document.getElementById('nombre_opcion').value = '';
    document.getElementById('descripcion_opcion').value = '';
    document.getElementById('imagen_opcion').value = '';
    document.getElementById('preview-imagen-opcion').classList.add('d-none');
    document.getElementById('preview-imagen-opcion').src = '#';
    document.getElementById('error-imagen-opcion').textContent = '';
    document.getElementById('error-imagen-opcion').style.display = 'none';
}

window.editarOpcion = function(id, nombre, descripcion, imagen) {
    document.getElementById('opcion_id').value = id;
    document.getElementById('nombre_opcion').value = nombre;
    document.getElementById('descripcion_opcion').value = descripcion || '';
    document.getElementById('imagen_opcion').value = '';
    const preview = document.getElementById('preview-imagen-opcion');
    if (imagen) {
        preview.src = imagen;
        preview.classList.remove('d-none');
    } else {
        preview.classList.add('d-none');
        preview.src = '#';
    }
    document.getElementById('error-imagen-opcion').textContent = '';
    document.getElementById('error-imagen-opcion').style.display = 'none';
    document.getElementById('modalOpcionLabel').textContent = 'Editar Opción';
    new bootstrap.Modal(document.getElementById('modalOpcion')).show();
}

window.eliminarOpcion = function(id) {
    if (confirm('¿Seguro que deseas eliminar esta opción?')) {
        fetch('../php/personalizacion/eliminar_opcion.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'opc_id=' + encodeURIComponent(id)
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                cargarOpciones();
            } else {
                alert(data.error || 'Error al eliminar');
            }
        });
    }
}
