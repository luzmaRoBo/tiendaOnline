//eliminacion de productos
function confirmarEliminacion() {
    return confirm("¿Estás seguro de que deseas eliminar este producto??");
}

//eliminacion de Usuarios
function confirmarEliminacionUsu() {
    return confirm("¿Estás seguro de que deseas eliminar este usuario??");
}

//modal para añadir productos
 function abrirModal(){
    document.getElementById("modal").style.display="block";
}
//cerrar modal añadir productos
function cerrar(){
    document.getElementById("modal").style.display="none";
}
//cerrar modal modificar productos
function cerrar1(){
    document.getElementById("modal1").style.display="none";
}

//modal para añadir usuarios
function abrirModalU(){
    document.getElementById("modalUsu").style.display="block";
}
//cerrar modal para añadir usuarios
function cerrarU(){
    document.getElementById("modalUsu").style.display="none";
}
//cerrar modal para modificar usuarios
function cerrar1U(){
    document.getElementById("modalUsuMod").style.display="none";
}

function abrirModalMod(id, nombre, pass, rol) {
    // Asigna los valores a los inputs del modal usando el atributo "name"
    document.getElementsByName("idUsuarioMod")[0].value = id;
    document.getElementsByName("modNombre")[0].value = nombre;
    document.getElementsByName("modRol")[0].value = rol;
    
    // Muestra el modal (asegúrate de tener definido en CSS que el modal esté oculto por defecto)
    document.getElementById("modalUsuMod").style.display = "block";
  }
//cerrar modal del inicio
  function cerrarL(){
    document.getElementById("modalInicio").style.display="none";
}