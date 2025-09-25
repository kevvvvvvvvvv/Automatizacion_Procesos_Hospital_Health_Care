import React, { useState } from 'react';
import './PacienteForm.css';  // Importa los estilos CSS

function PacienteForm() {
  // Estados para cada campo (inicializados vacíos)
  const [curpp, setCurpp] = useState('');
  const [nombre, setNombre] = useState('');
  const [apellidop, setApellidop] = useState('');
  const [apellidom, setApellidom] = useState('');
  const [sexo, setSexo] = useState('Masculino');
  const [fechaNacimiento, setFechaNacimiento] = useState('');
  const [calle, setCalle] = useState('');
  const [numeroExterior, setNumeroExterior] = useState('');
  const [numeroInterior, setNumeroInterior] = useState('');  // Nullable
  const [colonia, setColonia] = useState('');
  const [municipio, setMunicipio] = useState('');
  const [estado, setEstado] = useState('');
  const [pais, setPais] = useState('');
  const [cp, setCp] = useState('');
  const [telefono, setTelefono] = useState('');
  const [estadoCivil, setEstadoCivil] = useState('soltero(a)');
  const [ocupacion, setOcupacion] = useState('');
  const [lugarOrigen, setLugarOrigen] = useState('');
  const [nombrePadre, setNombrePadre] = useState('');  // Nullable
  const [nombreMadre, setNombreMadre] = useState('');  // Nullable

  // Función para manejar el envío
  const manejarEnvio = () => {
    // Validación básica: campos obligatorios no vacíos
    const camposObligatorios = {
      curpp, nombre, apellidop, apellidom, calle, numeroExterior, colonia,
      municipio, estado, pais, cp, telefono, ocupacion, lugarOrigen
    };
    const vacio = Object.values(camposObligatorios).some(valor => !valor.trim());
    if (vacio) {
      alert('Por favor, llena todos los campos obligatorios.');
      return;
    }

    // Campos nullable se permiten vacíos
    const datosPaciente = {
      curpp,
      nombre,
      apellidop,
      apellidom,
      sexo,
      fechaNacimiento,
      calle,
      numeroExterior,
      numeroInterior: numeroInterior || null,
      colonia,
      municipio,
      estado,
      pais,
      cp,
      telefono,
      estadoCivil,
      ocupacion,
      lugarOrigen,
      nombrePadre: nombrePadre || null,
      nombreMadre: nombreMadre || null
    };

    // Por ahora, muestra en alert (puedes cambiar por fetch a API)
    alert(`¡Paciente registrado!\nCURP: ${curpp}\nNombre completo: ${nombre} ${apellidop} ${apellidom}\nEmail: ${JSON.stringify(datosPaciente, null, 2)}`);
    console.log('Datos enviados:', datosPaciente);  // Para depuración
  };

  // Función para limpiar el formulario
  const limpiarFormulario = () => {
    setCurpp('');
    setNombre('');
    setApellidop('');
    setApellidom('');
    setSexo('Masculino');
    setFechaNacimiento('');
    setCalle('');
    setNumeroExterior('');
    setNumeroInterior('');
    setColonia('');
    setMunicipio('');
    setEstado('');
    setPais('');
    setCp('');
    setTelefono('');
    setEstadoCivil('soltero(a)');
    setOcupacion('');
    setLugarOrigen('');
    setNombrePadre('');
    setNombreMadre('');
  };

  return (
    <div className="contenedor-form">
      <h1>Registro de Paciente</h1>

      {/* Sección 1: Datos Personales */}
      <div className="seccion">
        <h3>Datos Personales</h3>
        <div>
          <label className="label-input">CURP (18 caracteres):</label>
          <input
            type="text"
            placeholder="Ej: ABCD123456HDFGHL09"
            value={curpp}
            onChange={(e) => setCurpp(e.target.value.toUpperCase())}  // Convierte a mayúsculas
            className="input-personalizado"
            maxLength={18}
          />
        </div>
        <div>
          <label className="label-input">Nombre(s):</label>
          <input type="text" placeholder="Ingresa el nombre" value={nombre} onChange={(e) => setNombre(e.target.value)} className="input-personalizado" />
        </div>
        <div>
          <label className="label-input">Apellido Paterno:</label>
          <input type="text" placeholder="Ingresa apellido paterno" value={apellidop} onChange={(e) => setApellidop(e.target.value)} className="input-personalizado" />
        </div>
        <div>
          <label className="label-input">Apellido Materno:</label>
          <input type="text" placeholder="Ingresa apellido materno" value={apellidom} onChange={(e) => setApellidom(e.target.value)} className="input-personalizado" />
        </div>
        <div>
          <label className="label-input">Sexo:</label>
          <select value={sexo} onChange={(e) => setSexo(e.target.value)} className="select-personalizado">
            <option value="Masculino">Masculino</option>
            <option value="Femenino">Femenino</option>
          </select>
        </div>
        <div>
          <label className="label-input">Fecha de Nacimiento:</label>
          <input
            type="date"
            value={fechaNacimiento}
            onChange={(e) => setFechaNacimiento(e.target.value)}
            className="input-personalizado"
          />
        </div>
        <div>
          <label className="label-input">Estado Civil:</label>
          <select value={estadoCivil} onChange={(e) => setEstadoCivil(e.target.value)} className="select-personalizado">
            <option value="soltero(a)">Soltero(a)</option>
            <option value="casado(a)">Casado(a)</option>
            <option value="divorciado(a)">Divorciado(a)</option>
            <option value="viudo(a)">Viudo(a)</option>
            <option value="union_libre">Unión Libre</option>
          </select>
        </div>
        <div>
          <label className="label-input">Ocupación:</label>
          <input type="text" placeholder="Ingresa ocupación" value={ocupacion} onChange={(e) => setOcupacion(e.target.value)} className="input-personalizado" />
        </div>
        <div>
          <label className="label-input">Lugar de Origen:</label>
          <input type="text" placeholder="Ej: Ciudad de México" value={lugarOrigen} onChange={(e) => setLugarOrigen(e.target.value)} className="input-personalizado" />
        </div>
      </div>

      {/* Sección 2: Dirección */}
      <div className="seccion">
        <h3>Domicilio</h3>
        <div>
          <label className="label-input">Calle:</label>
          <input type="text" placeholder="Ingresa la calle" value={calle} onChange={(e) => setCalle(e.target.value)} className="input-personalizado" />
        </div>
        <div>
          <label className="label-input">Número Exterior:</label>
          <input type="text" placeholder="Ej: 123" value={numeroExterior} onChange={(e) => setNumeroExterior(e.target.value)} className="input-personalizado" />
        </div>
        <div>
          <label className="label-input">Número Interior (opcional):</label>
          <input type="text" placeholder="Ej: Dept 4B" value={numeroInterior} onChange={(e) => setNumeroInterior(e.target.value)} className="input-personalizado" />
        </div>
        <div>
          <label className="label-input">Colonia:</label>
          <input type="text" placeholder="Ingresa colonia" value={colonia} onChange={(e) => setColonia(e.target.value)} className="input-personalizado" />
        </div>
        <div>
          <label className="label-input">Municipio:</label>
          <input type="text" placeholder="Ej: Cuauhtémoc" value={municipio} onChange={(e) => setMunicipio(e.target.value)} className="input-personalizado" />
        </div>
        <div>
          <label className="label-input">Estado:</label>
          <input type="text" placeholder="Ej: Ciudad de México" value={estado} onChange={(e) => setEstado(e.target.value)} className="input-personalizado" />
        </div>
        <div>
          <label className="label-input">País:</label>
          <input type="text" placeholder="Ej: México" value={pais} onChange={(e) => setPais(e.target.value)} className="input-personalizado" />
        </div>
        <div>
          <label className="label-input">Código Postal:</label>
          <input type="text" placeholder="Ej: 06500" value={cp} onChange={(e) => setCp(e.target.value)} className="input-personalizado" maxLength={5} />
        </div>
        <div>
          <label className="label-input">Teléfono:</label>
          <input type="tel" placeholder="Ej: 55-1234-5678" value={telefono} onChange={(e) => setTelefono(e.target.value)} className="input-personalizado" />
        </div>
      </div>

      {/* Sección 3: Datos Familiares */}
      <div className="seccion">
        <h3>Datos Familiares (Opcionales)</h3>
        <div>
          <label className="label-input">Nombre del Padre:</label>
          <input type="text" placeholder="Ingresa nombre del padre" value={nombrePadre} onChange={(e) => setNombrePadre(e.target.value)} className="input-personalizado" />
        </div>
        <div>
          <label className="label-input">Nombre de la Madre:</label>
          <input type="text" placeholder="Ingresa nombre de la madre" value={nombreMadre} onChange={(e) => setNombreMadre(e.target.value)} className="input-personalizado" />
        </div>
      </div>

      {/* Botones */}
      <div style={{ textAlign: 'center', marginTop: '20px' }}>
        <button type="button" onClick={manejarEnvio} className="boton-enviar">
          Enviar Datos
        </button>
        <button type="button" onClick={limpiarFormulario} className="boton-limpiar">
          Limpiar Formulario
        </button>
      </div>
    </div>
  );
}

export default PacienteForm;
