const API_BASE = "../api/libros.php";

async function cargarLibros() {
  const res = await fetch(API_BASE);
  const libros = await res.json();

  const lista = document.getElementById("listaLibros");
  lista.innerHTML = "";

  libros.forEach(libro => {
    const li = document.createElement("li");

    li.innerHTML = `
      <strong>${libro.titulo}</strong><br>
      ${libro.ubicacion}<br>
      <button onclick="verDetalle(${libro.idLibro})">Detalle</button>
      <button onclick="eliminarLibro(${libro.idLibro})">Eliminar</button>
    `;

    lista.appendChild(li);
  });
}

async function verDetalle(id) {
  const res = await fetch(`${API_BASE}?id=${id}`);
  const libro = await res.json();

  document.getElementById("detalle").textContent =
    JSON.stringify(libro, null, 2);
}

async function eliminarLibro(id) {
  const res = await fetch(`${API_BASE}?id=${id}`, {
    method: "DELETE"
  });

  const resultado = await res.json();
  document.getElementById("mensaje").textContent = resultado.mensaje || resultado.error;

  cargarLibros();
  document.getElementById("detalle").textContent = "";
}

async function crearLibro() {
  const data = {
    titulo: document.getElementById("titulo").value,
    paginas: Number(document.getElementById("paginas").value),
    ubicacionId: Number(document.getElementById("ubicacion").value),
    autoresIds: document.getElementById("autores").value.split(",").map(x => Number(x.trim())),
    generosIds: document.getElementById("generos").value.split(",").map(x => Number(x.trim())),
    editorialesIds: document.getElementById("editoriales").value.split(",").map(x => Number(x.trim()))
  };

  const res = await fetch(API_BASE, {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify(data)
  });

  const resultado = await res.json();
  document.getElementById("mensaje").textContent = resultado.error || "Libro creado correctamente";

  cargarLibros();
}

cargarLibros();