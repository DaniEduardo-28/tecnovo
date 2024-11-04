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

function loadOrdenesGasto(limit = 10, offset = 0, valor = "", fechaInicio = "", fechaFin = "", tipoBusqueda = "") {
  $.ajax({
      url: 'showOrdenGasto.php',
      type: 'POST',
      dataType: 'json',
      data: {
          limit: limit,
          offset: offset,
          valor: valor,
          fecha_inicio: fechaInicio,
          fecha_fin: fechaFin,
          tipo_busqueda: tipoBusqueda
      },
      success: function(response) {
          if (response.error === "NO") {
              const ordenes = response.data;
              let html = '';
              
              ordenes.forEach(orden => {
                  html += `
                      <tr>
                          <td>${orden.num}</td>
                          <td>${orden.nombre_proveedor}</td>
                          <td>${orden.name_usuario}</td>
                          <td>${orden.fecha_gasto}</td>
                          <td>${orden.num_registros}</td>
                          <td>${orden.total}</td>
                          <td>${orden.options}</td>
                      </tr>
                  `;
              });
              
              $('#tablaOrdenGasto tbody').html(html);
          } else {
              alert(response.message);
          }
      },
      error: function() {
          alert('Error al cargar las órdenes de gasto.');
      }
  });
}

$('#btnSave').on('click', function(event) {
  event.preventDefault();
  const data = {
      id_documento: $('#codigo_documento_cliente').val(),
      id_documento_venta: $('#codigo_documento_venta').val(),
      id_moneda: $('#codigo_moneda').val(),
      id_proveedor: $('#codigo_proveedor').val(),
      id_gasto: $('#codigo_gasto').val(),
      id_servicio: $('#codigo_servicio').val(),
      serie: $('#serie').val(),
      correlativo: $('#correlativo').val(),
      fecha_gasto: $('#fecha').val()
  };

  $.ajax({
      url: 'goOrdenGasto.php',
      type: 'POST',
      dataType: 'json',
      data: data,
      success: function(response) {
          if (response.error === "NO") {
              alert(response.message);
              loadOrdenesGasto(); // Recargar la lista de órdenes de gasto
          } else {
              alert(response.message);
          }
      },
      error: function() {
          alert('Error al guardar la orden de gasto.');
      }
  });
});

function editOrdenGasto(id) {
  $.ajax({
      url: 'getDataEditOrdenGasto.php',
      type: 'POST',
      dataType: 'json',
      data: { id_orden_gasto: id },
      success: function(response) {
          if (response.error === "NO") {
              const data = response.data[0];
              $('#codigo_documento_cliente').val(data.id_documento);
              $('#codigo_documento_venta').val(data.id_documento_venta);
              $('#codigo_moneda').val(data.id_moneda);
              $('#codigo_proveedor').val(data.id_proveedor);
              $('#codigo_gasto').val(data.id_gasto);
              $('#codigo_servicio').val(data.id_servicio);
              $('#serie').val(data.serie);
              $('#correlativo').val(data.correlativo);
              $('#fecha').val(data.fecha_gasto);
              $('#btnSave').data('edit', id); // Agregar el id a un atributo de datos
          } else {
              alert(response.message);
          }
      },
      error: function() {
          alert('Error al obtener los datos de la orden de gasto.');
      }
  });
}


function deleteOrdenGasto(id) {
  if (confirm('¿Estás seguro de que deseas eliminar esta orden de gasto?')) {
      $.ajax({
          url: 'deleteOrdenGasto.php',
          type: 'POST',
          dataType: 'json',
          data: { id_orden_gasto: id },
          success: function(response) {
              if (response.error === "NO") {
                  alert(response.message);
                  loadOrdenesGasto(); // Recargar la lista de órdenes de gasto
              } else {
                  alert(response.message);
              }
          },
          error: function() {
              alert('Error al eliminar la orden de gasto.');
          }
      });
  }
}

$(document).ready(function() {
  loadOrdenesGasto(); // Llamada inicial para cargar la lista de órdenes de gasto
});

let opcionSeleccionada = ""; // Puede ser 'servicio' o 'producto'

// Función que muestra el modal con la tabla de servicios o productos
function mostrarModalSeleccion(opcion) {
  opcionSeleccionada = opcion;
  $('#modalTable tbody').empty(); // Limpiamos la tabla del modal

  // Definimos el origen de los datos
  const url = opcion === "servicio" ? "getServicios.php" : "getProductos.php";

  // Hacemos la solicitud AJAX para obtener los datos
  $.ajax({
      url: url,
      type: 'POST',
      dataType: 'json',
      success: function(response) {
          if (response.error === "NO") {
              let html = '';
              response.data.forEach((item, index) => {
                  html += `
                      <tr>
                          <td>${index + 1}</td>
                          <td>${item.codigo}</td>
                          <td>${item.descripcion}</td>
                          <td><button type="button" class="btn btn-success btn-sm" onclick="añadirItem('${opcionSeleccionada}', '${item.codigo}', '${item.descripcion}')">Añadir</button></td>
                      </tr>
                  `;
              });
              $('#modalTable tbody').html(html);
          } else {
              alert(response.message);
          }
      },
      error: function() {
          alert('Error al cargar los datos.');
      }
  });

  // Mostrar el modal
  $('#modalAgregarDetalle').modal('show');
}

function añadirItem(tipo, codigo, descripcion) {
  const nombreTabla = tipo === "servicio" ? "Servicio" : "Producto";

  // Añadimos la fila a la tabla principal
  const nuevaFila = `
      <tr>
          <td>${nombreTabla}</td>
          <td>${codigo}</td>
          <td>${descripcion}</td>
          <td><input type="number" class="form-control" min="1" value="1" onchange="calcularSubtotal(this)"></td>
          <td><input type="number" class="form-control" step="0.01" min="0" value="0.00" onchange="calcularSubtotal(this)"></td>
          <td><input type="number" class="form-control" step="0.01" min="0" value="0.00"></td>
          <td class="subtotal">0.00</td>
          <td>
              <select class="form-control" onchange="calcularIGV(this)">
                  <option value="0">Exento</option>
                  <option value="0.18">18%</option>
              </select>
          </td>
          <td class="igv">0.00</td>
          <td class="total">0.00</td>
          <td><button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">X</button></td>
      </tr>
  `;

  $('#example1 tbody').append(nuevaFila);
  $('#modalAgregarDetalle').modal('hide'); // Cerrar el modal después de añadir el elemento
}

function calcularSubtotal(elemento) {
  const fila = $(elemento).closest('tr');
  const cantidad = parseFloat(fila.find('input').eq(0).val()) || 0;
  const precioUnitario = parseFloat(fila.find('input').eq(1).val()) || 0;
  const descuento = parseFloat(fila.find('input').eq(2).val()) || 0;
  const subtotal = (cantidad * precioUnitario) - descuento;

  fila.find('.subtotal').text(subtotal.toFixed(2));
  calcularTotal(fila);
}

function calcularIGV(elemento) {
  const fila = $(elemento).closest('tr');
  calcularTotal(fila);
}

function calcularTotal(fila) {
  const subtotal = parseFloat(fila.find('.subtotal').text()) || 0;
  const tipoIGV = parseFloat(fila.find('select').val()) || 0;
  const igv = subtotal * tipoIGV;
  const total = subtotal + igv;

  fila.find('.igv').text(igv.toFixed(2));
  fila.find('.total').text(total.toFixed(2));
}

function eliminarFila(elemento) {
  $(elemento).closest('tr').remove();
}



