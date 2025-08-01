document.getElementById("productForm").addEventListener("submit", async function (e) {
  e.preventDefault(); 

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
  const response = await fetch('/backend/check_codigo.php?codigo=' + encodeURIComponent(code)); // Consulta al backend si el codigo existe
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

  // Si todo está correcto
  productosRegistrados.add(code.toLowerCase()); // Simulamos guardado del código
  alert("Producto registrado con éxito.");
  form.reset();
});
