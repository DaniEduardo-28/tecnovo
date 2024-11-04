// Calcular subtotal y total
function calcularTotales() {
  const cantidad = parseFloat(document.getElementById('cantidad_solicitada').value) || 0;
  const precio = parseFloat(document.getElementById('precio_unitario').value) || 0;
  const descuento = parseFloat(document.getElementById('descuento').value) || 0;
  const subtotal = (cantidad * precio) - descuento;

  document.getElementById('txtGravada').value = subtotal.toFixed(2);

  const igv = parseFloat(document.getElementById('txtIgv').value) || 1;
  const total = subtotal * igv;
  document.getElementById('txtTotal').value = total.toFixed(2);
}

// Manejar el envío del formulario
async function enviarFormulario() {
  const data = {
      codigo_documento_venta: document.getElementById('codigo_documento_venta').value,
      serie: document.getElementById('serie').value,
      correlativo: document.getElementById('correlativo').value,
      codigo_documento_cliente: document.getElementById('codigo_documento_cliente').value,
      numero_documento_cliente: document.getElementById('numero_documento_cliente').value,
      nombres: document.getElementById('nombres').value,
      apellidos: document.getElementById('apellidos').value,
      direccion: document.getElementById('direccion').value,
      telefono: document.getElementById('telefono').value,
      correo: document.getElementById('correo').value,
      fecha: document.getElementById('fecha').value,
      codigo_moneda: document.getElementById('codigo_moneda').value,
      cantidad_solicitada: document.getElementById('cantidad_solicitada').value,
      precio_unitario: document.getElementById('precio_unitario').value,
      descuento: document.getElementById('descuento').value,
      subtotal: document.getElementById('txtGravada').value,
      igv: document.getElementById('txtIgv').value,
      total: document.getElementById('txtTotal').value,
  };

  try {
      const response = await fetch('/api/gastos/orden-gasto', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json'
          },
          body: JSON.stringify(data)
      });

      if (response.ok) {
          alert('Registro guardado con éxito');
          // Aquí puedes añadir lógica para resetear el formulario si es necesario
      } else {
          alert('Error al guardar el registro');
      }
  } catch (error) {
      console.error('Error:', error);
      alert('Error al conectar con el servidor');
  }
}

// Listeners para cálculo automático
document.getElementById('cantidad_solicitada').addEventListener('input', calcularTotales);
document.getElementById('precio_unitario').addEventListener('input', calcularTotales);
document.getElementById('descuento').addEventListener('input', calcularTotales);
document.getElementById('txtIgv').addEventListener('input', calcularTotales);

// Asignar función de envío al botón Guardar
document.getElementById('btnSave').addEventListener('click', function (event) {
  event.preventDefault();
  enviarFormulario();
});
