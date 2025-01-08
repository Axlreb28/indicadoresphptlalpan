@extends('layouts.base')

@section('title', 'Formulario de Datos')

@section('content')
<head>
    <link rel="stylesheet" href="{{ asset('css/formulario.css') }}">
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        let map;
        let marker;

        function initMap() {
            const tlalpanCoords = { lat: 19.287860, lng: -99.171360 };
            map = L.map('map').setView([tlalpanCoords.lat, tlalpanCoords.lng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            marker = L.marker([tlalpanCoords.lat, tlalpanCoords.lng], {draggable: true}).addTo(map);

            marker.on('dragend', function(event) {
                const position = marker.getLatLng();
                updateLocation(position);
            });
        }

        function updateLocation(location) {
            document.getElementById('ubicacion').value = location.lat + ', ' + location.lng;
            fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${location.lat}&lon=${location.lng}`)
                .then(response => response.json())
                .then(data => {
                    if (data.address) {
                        const address = `${data.address.road || ''}, ${data.address.suburb || ''}, ${data.address.city || ''}, ${data.address.state || ''}, ${data.address.country || ''}`;
                        document.getElementById('direccion').value = address;
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function toggleMap() {
            const mapContainer = document.getElementById('map-container');
            if (mapContainer.style.display === 'none' || mapContainer.style.display === '') {
                mapContainer.style.display = 'block';
                initMap();
            } else {
                mapContainer.style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('map-container').style.display = 'none';
        });

        document.addEventListener('DOMContentLoaded', function() {
            const selectDimension = document.getElementById('dimension_programa');
            const facilitadoresDiv = document.getElementById('facilitadores');
            const colectivosDiv = document.getElementById('colectivos');

            selectDimension.addEventListener('change', function() {
                facilitadoresDiv.style.display = this.value === 'facilitadores' ? 'block' : 'none';
                colectivosDiv.style.display = this.value === 'colectivos' ? 'block' : 'none';
            });
        });
    </script>
</head>

<body>
    <div class="container">
        <form class="miFormulario" action="">
            <div class="row">
                <div class="column">
                    <h2 class="title">Apoyo para el bienestar 2025</h2>
                    <div class="form-group">
                        <label for="dimension_programa">Dimensión del Programa:</label>
                        <select id="dimension_programa" name="dimension_programa">
                            <option value="">Seleccione una dimensión</option>
                            <option value="beneficiario">Beneficiario Directo</option>
                            <option value="facilitadores">Facilitadores</option>
                            <option value="colectivos">Colectivos</option>
                            <option value="usuarios">Usuarios</option>
                        </select>
                    </div>
                    <div id="facilitadores" class="hidden" style="display: none;">
                        <h3>Facilitadores</h3>
                        <div class="form-group">
                            <label for="facilitador">Facilitador:</label>
                            <select id="facilitador" name="facilitador">
                                <option value="">--Seleccione una opción--</option>
                                <option value="Coordinador1">Coordinador</option>
                                <option value="apoyoadmi2">Apoyo Administrativo</option>
                            </select>
                        </div>
                        <label for="actividad">Actividad:</label>
                        <select id="actividad" name="actividad">
                            <option value="">--Seleccione una actividad--</option>
                            <option value="actividad1">Sistematización</option>
                            <option value="actividad2">Capacitación</option>
                            <option value="actividad3">Evaluación</option>
                            <option value="actividad4">Supervisión</option>
                            <option value="actividad5">Seguimiento</option>
                            <option value="actividad6">Programación</option>
                            <option value="actividad8">Otro</option>
                        </select>
                    </div>
                    <div id="colectivos" class="hidden" style="display: none;">
                        <h3>Colectivos</h3>
                        <div class="form-group">
                            <label for="colec">Colectivo:</label>
                            <select id="colec" name="colec">
                                <option value="">Seleccione un colectivo</option>
                                <option value="Tlalpan1">Tlalpan 1</option>
                                <option value="Tlalpan2">Tlalpan 2</option>
                                <option value="Tlalpan3">Tlalpan 3</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tperson">Persona representante:</label>
                            <select id="tperson" name="tperson">
                                <option value="">Seleccione una persona</option>
                                <option value="persona1">Coordinador</option>
                                <option value="persona2">Integrante</option>
                                <option value="persona3">Usuario</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <h3>Datos de la persona beneficiaria</h3>
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="apellido">Apellido materno:</label>
                    <input type="text" id="apellido" name="apellido" required>
                </div>
                <div class="form-group">
                    <label for="apellido2">Apellido paterno:</label>
                    <input type="text" id="apellido2" name="apellido2" required>
                </div>
                <div class="form-group">
                    <label for="sexo">Sexo:</label>
                    <select id="sexo" name="sexo">
                        <option value="hombre">Hombre</option>
                        <option value="mujer">Mujer</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono:</label>
                    <input type="text" id="telefono" name="telefono">
                </div>
                <div class="form-group">
                    <label for="fecha_nacimiento">Fecha de nacimiento:</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento">
                </div>
                <div class="flex">
                    <div class="form-group">
                        <label for="colonia">Colonia:</label>
                        <option value="">Seleccione una colonia</option>
                                <option value="MESA LOS HORNOS">MESA LOS HORNOS, TEXCALTENCO</option>
                                <option value="MIRADOR">MIRADOR 1A SECC</option>
                                <option value="LA PRIMAVERA">LA PRIMAVERA</option>
                                <option value="LOMAS ALTAS DE PADIERNA SUR">LOMAS ALTAS DE PADIERNA SUR</option>
                                <option value="LOMAS DE PADIERNA (AMPL)">LOMAS DE PADIERNA (AMPL)</option>
                                <option value="SAN PEDRO MARTIR (PBLO)">SAN PEDRO MARTIR (PBLO)</option>
                                <option value="TLALCOLIGIA">TLALCOLIGIA</option>
                                <option value="SAUZALES CEBADALES (U HAB)">SAUZALES CEBADALES (U HAB)</option>
                                <option value="SAN ANDRES TOTOLTEPEC (PBLO)">SAN ANDRES TOTOLTEPEC (PBLO)</option>
                                <option value="SAN MIGUEL XICALCO (PBLO)">SAN MIGUEL XICALCO (PBLO)</option>
                                <option value="LOMAS DE PADIERNA II">LOMAS DE PADIERNA II</option>
                                <option value="XAXALCO">XAXALCO</option>
                                <option value="ISIDRO FABELA II (ORIENTE)">ISIDRO FABELA II (ORIENTE)</option>
                                <option value="JARDINES EN LA MONTAA">JARDINES EN LA MONTAA</option>
                                <option value="JARDINES DEL AJUSCO">JARDINES DEL AJUSCO</option>
                                <option value="AYOCATITLA, ASUNCIN">AYOCATITLA, ASUNCIN</option>
                                <option value="ARBOLEDAS DEL SUR">ARBOLEDAS DEL SUR</option>
                                <option value="UNIDADES HABITACIONALES DE TENORIOS">UNIDADES HABITACIONALES DE TENORIOS</option>
                                <option value="DOLORES TLALI">DOLORES TLALI</option>
                                <option value="EL ZACATON">EL ZACATON</option>
                                <option value="HUESO PERIFERICO-ISSSFAM NO. 7 (U HABS)">HUESO PERIFERICO-ISSSFAM NO. 7 (U HABS)</option>
                                <option value="SAN MIGUEL TOPILEJO (PBLO)">SAN MIGUEL TOPILEJO (PBLO)</option>
                                <option value="TORIELLO GUERRA">TORIELLO GUERRA</option>
                                <option value="VIVEROS DE COACTETLAN">VIVEROS DE COACTETLAN</option>
                                <option value="PEDREGAL DE SN NICOLAS 4A SECC I">PEDREGAL DE SN NICOLAS 4A SECC I</option>
                                <option value="LOMAS DE TEPEMECATL">LOMAS DE TEPEMECATL</option>
                                <option value="LA PALMA">LA PALMA</option>
                                <option value="MOVIMIENTO ORGANIZADO DE TLALPAN-EL MIRADOR (RNCDA)">MOVIMIENTO ORGANIZADO DE TLALPAN-EL MIRADOR (RNCDA)</option>
                                <option value="LA LONJA">LA LONJA</option>
                                <option value="LOMAS HIDALGO">LOMAS HIDALGO</option>
                                <option value="LA TORTUGA XOLALPA-HCO COLEGIO MILITAR">LA TORTUGA XOLALPA-HCO COLEGIO MILITAR</option>
                                <option value="JARDINES DE SAN JUAN">JARDINES DE SAN JUAN</option>
                                <option value="FUENTES Y PEDREGAL DE TEPEPAN">FUENTES Y PEDREGAL DE TEPEPAN</option>
                                <option value="HEROES DE 1910">HEROES DE 1910</option>
                                <option value="PARQUES DEL PEDREGAL">PARQUES DEL PEDREGAL</option>
                                <option value="PARAJE 38">PARAJE 38</option>
                                <option value="EL ARENAL">EL ARENAL</option>
                                <option value="CRUZ DEL FAROL">CRUZ DEL FAROL</option>
                                <option value="BOSQUE DE TEPEXIMILPA">BOSQUE DE TEPEXIMILPA</option>
                                <option value="TEZONTITLA">TEZONTITLA</option>
                                <option value="VALLE DE TEPEPAN">VALLE DE TEPEPAN</option>
                                <option value="VISTAS DEL PEDREGAL">VISTAS DEL PEDREGAL</option>
                                <option value="TEPETONGO">TEPETONGO</option>
                                <option value="CONDOMINIO DEL BOSQUE (FRACC)-BOSQUE DE TLALPAN">CONDOMINIO DEL BOSQUE (FRACC)-BOSQUE DE TLALPAN</option>
                                <option value="ISIDRO FABELA I (PONIENTE)">ISIDRO FABELA I (PONIENTE)</option>
                                <option value="LOS ENCINOS">LOS ENCINOS</option>
                                <option value="TEPETLICA EL ALTO-3 DE MAYO">TEPETLICA EL ALTO-3 DE MAYO</option>
                                <option value="PIEDRA LARGA">PIEDRA LARGA</option>
                                <option value="PROGRESO TLALPAN">PROGRESO TLALPAN</option>
                                <option value="HEROES DE PADIERNA II">HEROES DE PADIERNA II</option>
                                <option value="PEDREGAL DE SN NICOLAS 4A SECC II">PEDREGAL DE SN NICOLAS 4A SECC II</option>
                                <option value="CONJUNTO HABITACIONAL PEDREGAL DEL LAGO">CONJUNTO HABITACIONAL PEDREGAL DEL LAGO</option>
                                <option value="BELVEDERE">BELVEDERE</option>
                                <option value="PEDREGAL DE SN NICOLAS 1A SECC">PEDREGAL DE SN NICOLAS 1A SECC</option>
                                <option value="PEDREGAL DE SN NICOLAS 3A SECC">PEDREGAL DE SN NICOLAS 3A SECC</option>
                                <option value="RINCON LAS HADAS-VILLA ROYALE-FUENTES Y ARCONADA COAPA">RINCON LAS HADAS-VILLA ROYALE-FUENTES Y ARCONADA COAPA</option>
                                <option value="FUENTES DEL PEDREGAL">FUENTES DEL PEDREGAL</option>
                                <option value="AMPLIACION MIGUEL HIDALGO 4A SECC">AMPLIACION MIGUEL HIDALGO 4A SECC</option>
                                <option value="GRANJAS COAPA">GRANJAS COAPA</option>
                                <option value="BOSQUES DEL PEDREGAL">BOSQUES DEL PEDREGAL</option>
                                <option value="ARENAL GUADALUPE TLALPAN">ARENAL GUADALUPE TLALPAN</option>
                                <option value="SANTO TOMAS AJUSCO (PBLO)">SANTO TOMAS AJUSCO (PBLO)</option>
                                <option value="LOMAS DE PADIERNA I">LOMAS DE PADIERNA I</option>
                                <option value="2 DE OCTUBRE">2 DE OCTUBRE</option>
                                <option value="LA MAGDALENA PETLACALCO (PBLO)">LA MAGDALENA PETLACALCO (PBLO)</option>
                                <option value="JUVENTUD UNIDA">JUVENTUD UNIDA</option>
                                <option value="TLALPAN CENTRO">TLALPAN CENTRO</option>
                                <option value="TLALMILLE">TLALMILLE</option>
                                <option value="VERGEL DE COYOACAN-VERGEL DEL SUR">VERGEL DE COYOACAN-VERGEL DEL SUR</option>
                                <option value="VILLA LAZARO CARDENAS">VILLA LAZARO CARDENAS</option>
                                <option value="VERANO">VERANO</option>
                                <option value="REAL DEL SUR-VILLAS DEL SUR-RESIDENCIAL ACOXPA">REAL DEL SUR-VILLAS DEL SUR-RESIDENCIAL ACOXPA</option>
                                <option value="RINCONADA (U HAB)">RINCONADA (U HAB)</option>
                                <option value="AMSA">AMSA</option>
                                <option value="FUENTES BROTANTES MIGUEL HIDALGO (U HAB)">FUENTES BROTANTES MIGUEL HIDALGO (U HAB)</option>
                                <option value="ARENAL PUERTA TEPEPAN">ARENAL PUERTA TEPEPAN</option>
                                <option value="AMPLIACION MIGUEL HIDALGO 3A SECC">AMPLIACION MIGUEL HIDALGO 3A SECC</option>
                                <option value="CALVARIO CAMISETAS">CALVARIO CAMISETAS</option>
                                <option value="HACIENDA SAN JUAN-RINCON DE SAN JUAN-CHIMALI">HACIENDA SAN JUAN-RINCON DE SAN JUAN-CHIMALI</option>
                                <option value="COAPA 2A SECCION-RAMOS MILLAN">COAPA 2A SECCION-RAMOS MILLAN</option>
                                <option value="SANTA URSULA XITLA">SANTA URSULA XITLA</option>
                                <option value="PARRES EL GUARDA (PBLO)">PARRES EL GUARDA (PBLO)</option>
                                <option value="PRADO COAPA 3A SECCION-POTRERO ACOXPA">PRADO COAPA 3A SECCION-POTRERO ACOXPA</option>
                                <option value="PEDREGAL DE LAS AGUILAS">PEDREGAL DE LAS AGUILAS</option>
                                <option value="ROCA DE CRISTAL">ROCA DE CRISTAL</option>
                                <option value="VILLA DEL PUENTE FOVISSSTE (U HAB)">VILLA DEL PUENTE FOVISSSTE (U HAB)</option>
                                <option value="NARCISO MENDOZA-VILLA COAPA SUPER MANZANA 6 (U HAB)">NARCISO MENDOZA-VILLA COAPA SUPER MANZANA 6 (U HAB)</option>
                                <option value="LA JOYA">LA JOYA</option>
                                <option value="LOS PASTORES">LOS PASTORES</option>
                                <option value="IGNACIO CHAVEZ (U HAB)">IGNACIO CHAVEZ (U HAB)</option>
                                <option value="LOMAS DE TEXCALATLACO">LOMAS DE TEXCALATLACO</option>
                                <option value="FLORESTA-PRADO-VERGEL COAPA">FLORESTA-PRADO-VERGEL COAPA</option>
                                <option value="EMILIO PORTES GIL PEMEX PICACHO (U HAB)">EMILIO PORTES GIL PEMEX PICACHO (U HAB)</option>
                                <option value="FRESNO">FRESNO</option>
                                <option value="SAN MIGUEL TEHUISCO-LOS ANGELES-AYOMETITLA">SAN MIGUEL TEHUISCO-LOS ANGELES-AYOMETITLA</option>
                                <option value="NARCISO MENDOZA-VILLA COAPA SUPER MANZANA 7 (U HAB)">NARCISO MENDOZA-VILLA COAPA SUPER MANZANA 7 (U HAB)</option>
                                <option value="SAN BARTOLO EL CHICO">SAN BARTOLO EL CHICO</option>
                                <option value="PUEBLO QUIETO">PUEBLO QUIETO</option>
                                <option value="AMPLIACION MIGUEL HIDALGO 2A SECC">AMPLIACION MIGUEL HIDALGO 2A SECC</option>
                                <option value="CHICHICASPATL">CHICHICASPATL</option>
                                <option value="AHUACATITLA">AHUACATITLA</option>
                                <option value="CHIMILLI">CHIMILLI</option>
                                <option value="CUILOTEPEC II">CUILOTEPEC II</option>
                                <option value="XAXALIPAC">XAXALIPAC</option>
                                <option value="SAN PEDRO APOSTOL (BARR)">SAN PEDRO APOSTOL (BARR)</option>
                                <option value="VILLA COAPA (RDCIAL)">VILLA COAPA (RDCIAL)</option>
                                <option value="COLINAS DEL BOSQUE-LAS TORTOLAS">COLINAS DEL BOSQUE-LAS TORTOLAS</option>
                                <option value="LA FAMA">LA FAMA</option>
                                <option value="EJIDOS DE SAN PEDRO MARTIR I (NORTE)">EJIDOS DE SAN PEDRO MARTIR I (NORTE)</option>
                                <option value="PEDREGAL DE STA URSULA XITLA">PEDREGAL DE STA URSULA XITLA</option>
                                <option value="RANCHO LOS COLORINES (FRACC)">RANCHO LOS COLORINES (FRACC)</option>
                                <option value="VALLE ESCONDIDO">VALLE ESCONDIDO</option>
                                <option value="TETENCO (PJE)">TETENCO (PJE)</option>
                                <option value="CHIMALCOYOC">CHIMALCOYOC</option>
                                <option value="MIGUEL HIDALGO ORIENTE (AMPL)">MIGUEL HIDALGO ORIENTE (AMPL)</option>
                                <option value="SAN LORENZO HUIPULCO">SAN LORENZO HUIPULCO</option>
                                <option value="LA MAGUEYERA">LA MAGUEYERA</option>
                                <option value="TORRES DE PADIERNA">TORRES DE PADIERNA</option>
                                <option value="BELISARIO DOMINGUEZ">BELISARIO DOMINGUEZ</option>
                                <option value="EJIDOS DE SAN PEDRO MARTIR II (SUR)">EJIDOS DE SAN PEDRO MARTIR II (SUR)</option>
                                <option value="MA ESTHER ZUNO DE ECHEVERRIA-TLALPUENTE">MA ESTHER ZUNO DE ECHEVERRIA-TLALPUENTE</option>
                                <option value="LA LIBERTAD - IXTLAHUACA">LA LIBERTAD - IXTLAHUACA</option>
                                <option value="COAPA-VILLA CUEMANCO">COAPA-VILLA CUEMANCO</option>
                                <option value="TEZONTITLA - EL CALVARIO (AMPL)">TEZONTITLA - EL CALVARIO (AMPL)</option>
                                <option value="TENORIOS INFONAVIT 1 Y 2 (U HAB)">TENORIOS INFONAVIT 1 Y 2 (U HAB)</option>
                                <option value="PLAN DE AYALA">PLAN DE AYALA</option>
                                <option value="MIRADOR 2A y 3A SECC">MIRADOR 2A y 3A SECC</option>
                                <option value="POPULAR STA TERESA">POPULAR STA TERESA</option>
                                <option value="NUEVA ORIENTAL COAPA-EX HACIENDA COAPA">NUEVA ORIENTAL COAPA-EX HACIENDA COAPA</option>
                                <option value="MIRADOR II">MIRADOR II</option>
                                <option value="NIO JESUS (BARR)">NIO JESUS (BARR)</option>
                                <option value="ZAPOTE-LUIS DONALDO COLOSIO (U HABS)">ZAPOTE-LUIS DONALDO COLOSIO (U HABS)</option>
                                <option value="SAN MIGUEL TOXIAC">SAN MIGUEL TOXIAC</option>
                                <option value="JARDINES COAPA-BELISARIO DOMINGUEZ">JARDINES COAPA-BELISARIO DOMINGUEZ</option>
                                <option value="CONJUNTO URBANO CUEMANCO (U HAB)">CONJUNTO URBANO CUEMANCO (U HAB)</option>
                                <option value="EL DIVISADERO">EL DIVISADERO</option>
                                <option value="EX HACIENDA SAN JUAN DE DIOS">EX HACIENDA SAN JUAN DE DIOS</option>
                                <option value="GRANJAS COAPA ORIENTE">GRANJAS COAPA ORIENTE</option>
                                <option value="OCOTLA - OCOTLA CHICO">OCOTLA - OCOTLA CHICO</option>
                                <option value="TECORRAL">TECORRAL</option>
                                <option value="SANTISIMA TRINIDAD">SANTISIMA TRINIDAD</option>
                                <option value="VALLE VERDE">VALLE VERDE</option>
                                <option value="LOMA BONITA-AMPLIACION TEPEXIMILPA">LOMA BONITA-AMPLIACION TEPEXIMILPA</option>
                                <option value="NARCISO MENDOZA-VILLA COAPA SUPER MANZANA 1 (U HAB)">NARCISO MENDOZA-VILLA COAPA SUPER MANZANA 1 (U HAB)</option>
                                <option value="LOMAS DEL PEDREGAL">LOMAS DEL PEDREGAL</option>
                                <option value="NARCISO MENDOZA VILLA COAPA SUPERMANZANA 8 (U HAB)">NARCISO MENDOZA VILLA COAPA SUPERMANZANA 8 (U HAB)</option>
                                <option value="ISIDRO FABELA (AMPL)">ISIDRO FABELA (AMPL)</option>
                                <option value="MIRADOR DEL VALLE">MIRADOR DEL VALLE</option>
                                <option value="SAN MIGUEL AJUSCO (PBLO)">SAN MIGUEL AJUSCO (PBLO)</option>
                                <option value="MIRADOR I">MIRADOR I</option>
                                <option value="RESIDENCIAL INSURGENTES SUR (U HAB)">RESIDENCIAL INSURGENTES SUR (U HAB)</option>
                                <option value="SN JUAN TEPEXIMILPA (AMPL)">SN JUAN TEPEXIMILPA (AMPL)</option>
                                <option value="CULTURA MAYA">CULTURA MAYA</option>
                                <option value="HEROES DE PADIERNA I">HEROES DE PADIERNA I</option>
                                <option value="VILLA OLIMPICA LIBERADOR MIGUEL HIDALGO (U HAB)">VILLA OLIMPICA LIBERADOR MIGUEL HIDALGO (U HAB)</option>
                                <option value="SECCION XVI">SECCION XVI</option>
                                <option value="CLUB DE GOLF MEXICO-SAN BUENAVENTURA">CLUB DE GOLF MEXICO-SAN BUENAVENTURA</option>
                                <option value="ISSSFAM No. 1 (U HAB)-VILLA TLALPAN">ISSSFAM No. 1 (U HAB)-VILLA TLALPAN</option>
                                <option value="CUCHILLA DE PADIERNA">CUCHILLA DE PADIERNA</option>
                                <option value="LOMAS DE CUILOTEPEC">LOMAS DE CUILOTEPEC</option>
                                <option value="NARCISO MENDOZA-VILLA COAPA SUPER MANZANA 2 (U HAB)">NARCISO MENDOZA-VILLA COAPA SUPER MANZANA 2 (U HAB)</option>
                                <option value="NARCISO MENDOZA-VILLA COAPA SUPER MANZANA 3 (U HAB)">NARCISO MENDOZA-VILLA COAPA SUPER MANZANA 3 (U HAB)</option>
                                <option value="PEDREGAL DE SN NICOLAS 2A SECC">PEDREGAL DE SN NICOLAS 2A SECC</option>
                                <option value="ROMULO SANCHEZ-SAN FERNANDO (BARR)-PEA POBRE">ROMULO SANCHEZ-SAN FERNANDO (BARR)-PEA POBRE</option>
                                <option value="SN JUAN TEPEXIMILPA">SN JUAN TEPEXIMILPA</option>
                                <option value="ZACATIENDA">ZACATIENDA</option>
                                <option value="TRES FUENTES (U HAB)">TRES FUENTES (U HAB)</option>
                                <option value="LOS VOLCANES">LOS VOLCANES</option>
                                <option value="NUEVO RENACIMIENTO DE AXALCO">NUEVO RENACIMIENTO DE AXALCO</option>
                                <option value="LA GUADALUPANA">LA GUADALUPANA</option>
                                <option value="PRADO COAPA 2A SECCION">PRADO COAPA 2A SECCION</option>
                                <option value="ATOCPA SUR">ATOCPA SUR</option>
                                <option value="CANTERA PUENTE DE PIEDRA">CANTERA PUENTE DE PIEDRA</option>
                                <option value="DIAMANTE">DIAMANTE</option>
                                <option value="FOVISSSTE SAN PEDRO MARTIR (U HAB)">FOVISSSTE SAN PEDRO MARTIR (U HAB)</option>
                                <option value="SAN NICOLAS II">SAN NICOLAS II</option>
                                <option value="SOLIDARIDAD">SOLIDARIDAD</option>      
                        <select id="colonia" name="colonia">                           
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="ubicacion">Ubicación (Arrastra el PIN AZUL):</label>
                    <input type="text" id="ubicacion" name="ubicacion" style="display: none;" readonly>
                    <button type="button" onclick="toggleMap()">Seleccionar Ubicación</button>
                    <div id="map-container">
                        <div id="map" style="height: 400px;"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="direccion">Dirección:</label>
                    <input type="text" id="direccion" name="direccion" readonly>
                </div>
                <button type="submit" class="btn">Enviar</button>
            </div>
        </form>
    </div>
</body>
@endsection