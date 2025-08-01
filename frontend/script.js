// Para cargar las opciones de bodega, sucursal y moneda dinamicamente desde la base de datos
let sucursalesPorBodega = {};
async function cargarOpciones() {
  try {
    const res = await fetch('http://localhost/desis-admission/enum_values.php');
    if (!res.ok) throw new Error('Error al obtener opciones');
    const data = await res.json();
    
    // Asumimos selects con nombres 'warehouse', 'branch', 'currency'
    const selectWarehouse = document.querySelector('select[name="warehouse"]');
    const selectBranch = document.querySelector('select[name="branch"]');
    const selectCurrency = document.querySelector('select[name="currency"]');

    // Vaciar selects por si acaso
    selectWarehouse.innerHTML = '<option value="" disabled selected></option>';
    selectBranch.innerHTML = '<option value="" disabled selected></option>';
    selectCurrency.innerHTML = '<option value="" disabled selected></option>';
    
    // Llenar opciones de bodegas
    data.bodegas.forEach(bodega => {
      const option = document.createElement('option');
      option.value = bodega;
      option.textContent = bodega.charAt(0).toUpperCase() + bodega.slice(1);
      selectWarehouse.appendChild(option);
    });
    
    // Llenar opciones de sucursales
    sucursalesPorBodega = data.sucursales_por_bodega;

    // Escuchar cambios en el select de bodega
    selectWarehouse.addEventListener('change', () => {
      const seleccionada = selectWarehouse.value;
      const sucursales = sucursalesPorBodega[seleccionada] || [];

      // Limpiar el select de sucursales
      selectBranch.innerHTML = '<option value="" disabled selected></option>';

      // Añadir las sucursales correspondientes
      sucursales.forEach(sucursal => {
        const option = document.createElement('option');
        option.value = sucursal;
        option.textContent = sucursal.charAt(0).toUpperCase() + sucursal.slice(1);
        selectBranch.appendChild(option);
      });
    });
    
    // Llenar opciones de monedas
    data.monedas.forEach(moneda => {
      const option = document.createElement('option');
      option.value = moneda;
      option.textContent = moneda.toUpperCase();
      selectCurrency.appendChild(option);
    });
    
  } catch (error) {
    console.error('Error cargando opciones:', error);
    alert('No se pudieron cargar las opciones de bodega, sucursal y moneda.');
  }
}
document.addEventListener('DOMContentLoaded', cargarOpciones);


// Este es el listener del formulario que se encarga de validar los datos y enviarlos al backend
document.getElementById("productForm").addEventListener("submit", async function (e) {
  e.preventDefault(); 
// Preparar los datos para enviarlos a la base de datos
  const form = e.target;
  const code = form.code.value.trim();
  const name = form.name.value.trim();
  const price = form.price.value.trim();
  const warehouse = form.warehouse.value;
  const branch = form.branch.value;
  const currency = form.currency.value;
  const description = form.description.value.trim();
  const materials = Array.from(form.querySelectorAll('input[name="materials[]"]:checked'));

  // Validación de Código
  const codeRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{5,15}$/;
  if (code === "") {
    alert("El código del producto no puede estar en blanco.");
    return;
  }
  if (!codeRegex.test(code)) {
    alert("El código del producto debe contener letras y números");
    return;
  }
  if (code.length < 5 || code.length > 15) {
    alert("El código del producto debe tener entre 5 y 15 caracteres.");
    return;
  }
  const response = await fetch('/desis-admission/check_codigo.php?codigo=' + encodeURIComponent(code)); // Consulta al backend si el codigo existe
  const data = await response.json();
  if (data.exists) {
    alert("El código del producto ya está registrado.");
    return;
  }

  // Validación de Nombre
  if (name === "") {
    alert("El nombre del producto no puede estar en blanco.");
    return;
  }
  if (name.length < 2 || name.length > 50) {
    alert("El nombre del producto debe tener entre 2 y 50 caracteres.");
    return;
  }

  // Validación de Precio
  const priceRegex = /^\d+(\.\d{1,2})?$/;
  if (price === "") {
    alert("El precio del producto no puede estar en blanco.");
    return;
  }
  if (!priceRegex.test(price) || parseFloat(price) <= 0) {
    alert("El precio del producto debe ser un número positivo con hasta dos decimales.");
    return;
  }

  // Validación de Materiales
  if (materials.length < 2) {
    alert("Debe seleccionar al menos dos materiales para el producto.");
    return;
  }

  // Validación de Bodega
  if (warehouse === "") {
    alert("Debe seleccionar una bodega.");
    return;
  }

  // Validación de Sucursal
  if (branch === "") {
    alert("Debe seleccionar una sucursal para la bodega seleccionada.");
    return;
  }

  // Validación de Moneda
  if (currency === "") {
    alert("Debe seleccionar una moneda para el producto.");
    return;
  }

  // Validación de Descripción
  if (description === "") {
    alert("La descripción del producto no puede estar en blanco.");
    return;
  }
  if (description.length < 10 || description.length > 1000) {
    alert("La descripción del producto debe tener entre 10 y 1000 caracteres.");
    return;
  }

  const dataToSend = {
    codigo: code,
    nombre: name,
    precio: parseFloat(price),
    bodega: warehouse,
    sucursal: branch,
    moneda: currency,
    plastico: materials.some(m => m.value === 'plastic'),
    metal: materials.some(m => m.value === 'metal'),
    madera: materials.some(m => m.value === 'wood'),
    vidrio: materials.some(m => m.value === 'glass'),
    textil: materials.some(m => m.value === 'textil'),
    descripcion: description,
  };

  try {
    const response = await fetch('http://localhost/desis-admission/save_product.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(dataToSend)
    });

    const result = await response.json();

    if (response.ok) {
      alert(result.message || 'Producto registrado con éxito.');
      form.reset();
    } else {
      alert(result.error || 'Ocurrió un error al guardar el producto.');
    }
  } catch (error) {
    alert('Error en la conexión con el servidor: ' + error.message);
  }

});
