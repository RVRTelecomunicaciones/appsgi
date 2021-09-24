<?php

class tasacion_m extends CI_Model
{

    //INSERT INTO
    public function addTasacionesTerreno($data){
        $this->db->insert('t_terreno', $data);
        return true;
    }
    public function addTasacionesCasa($data){
        $this->db->insert('t_casa', $data);
        return true;
    }
    public function addTasacionesDepartamento($data){
        $this->db->insert('t_departamento', $data);
        return true;
    }
    public function addTasacionesLocalComercial($data){
        $this->db->insert('t_local_comercial', $data);
        return true;
    }
    public function addTasacionesLocalIndustrial($data){
        $this->db->insert('t_local_industrial', $data);
        return true;
    }
    public function addTasacionesOficina($data){
        $this->db->insert('t_oficina', $data);
        return true;
    }
    public function addTasacionesVehiculo($data){
        $this->db->insert('t_vehiculo', $data);
        return true;
    }
    public function addTasacionesMaquinaria($data){
        $this->db->insert('t_maquinaria', $data);
        return true;
    }
    ///<===========================================================>///
    public function tasacionesPorRegistrar(){

        $query = $this->db->query("select cotizacion_correlativo COORDINACION,
                            DATE_FORMAT(coor_coordinacion.info_create, '%d/%m/%y')  FECHA,
                            login1.full_name PERITO,
                            login2.full_name CONTROL_CALIDAD,
                            if(coor_coordinacion.solicitante_persona_tipo like 'Natural' ,coinna2.nombre,coinju2.nombre) as SOLICITANTE,
                            if(coor_coordinacion.cliente_persona_tipo like 'Natural' ,coinna.nombre,coinju.nombre) as CLIENTE
                            from coor_coordinacion
                            left join coor_inspeccion as coorin on coor_coordinacion.id = coorin.coordinacion_id
                            left join login_user as login1 on login1.id =  coorin.perito_id
                            left join login_user as login2 on login2.id =  coorin.inspector_id
                            left join co_involucrado_juridica as coinju on coor_coordinacion.cliente_persona_id = coinju.id
                            left join co_involucrado_natural as coinna on coor_coordinacion.cliente_persona_id = coinna.id
                            left join co_involucrado_juridica as coinju2 on coor_coordinacion.solicitante_persona_id = coinju2.id
                            left join co_involucrado_natural as coinna2 on coor_coordinacion.solicitante_persona_id = coinna2.id
                            where not exists (select 1 from t_terreno where t_terreno.informe_id = coor_coordinacion.cotizacion_correlativo)
                            and  not exists (select 1 from t_casa where t_casa.informe_id = coor_coordinacion.cotizacion_correlativo)
                            and  not exists (select 1 from t_departamento where t_departamento.informe_id = coor_coordinacion.cotizacion_correlativo)
                            and  not exists (select 1 from t_local_comercial where t_local_comercial.informe_id = coor_coordinacion.cotizacion_correlativo)
                            and  not exists (select 1 from t_local_industrial where t_local_industrial.informe_id = coor_coordinacion.cotizacion_correlativo)
                            and  not exists (select 1 from t_maquinaria where t_maquinaria.informe_id = coor_coordinacion.cotizacion_correlativo)
                            and  not exists (select 1 from t_vehiculo where t_vehiculo.informe_id = coor_coordinacion.cotizacion_correlativo)
                            and  not exists (select 1 from in_no_registrado where in_no_registrado.informe_id = coor_coordinacion.cotizacion_correlativo)
                            order by PERITO DESC;");
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }

	}

	public function tasacionAll(){
        // $query = $this->db->query("select 1 categoria,informe_id, ds.nombre solicitante,dc.nombre client, dp.nombre propietario,ubicacion,tasacion_fecha, mapa_latitud, mapa_longitud,zonificacion,dct.nombre,round(terreno_area,2) terreno_area, round(terreno_valorunitario,2) terreno_valorunitario,round(valor_comercial,2) valor_comercial, ruta_informe,null valor_ocupada
		// from t_terreno tt
		// left join diccionario_solicitante ds on tt.solicitante_id = ds.id
		// left join diccionario_cliente dc on tt.cliente_id = dc.id
		// left join diccionario_propietario dp on tt.propietario_id = dp.id
		// left join diccionario_cultivo_tipo  dct on tt.cultivo_tipo_id = dct.id
		// where estado = 1
		// union
		// select 2 categoria,informe_id, ds.nombre solicitante,dc.nombre client, dp.nombre propietario,ubicacion,tasacion_fecha, mapa_latitud, mapa_longitud,zonificacion,ddt.nombre depatipo,round(terreno_area,2) terreno_area, round(terreno_valorunitario,2) terreno_valorunitario,round(valor_comercial,2) valor_comercial,ruta_informe,round(valor_ocupada,2) valor_ocupada
		// from t_departamento td
		// left join diccionario_solicitante ds on td.solicitante_id = ds.id
		// left join diccionario_cliente dc on td.cliente_id = dc.id
		// left join diccionario_propietario dp on td.propietario_id = dp.id
		// left join diccionario_departamento_tipo  ddt on td.departamento_tipo_id = ddt.id");
		/*$query = $this->db->query("SELECT
                                	1 categoria,
                                	tas_terreno.id,
                                    informe_id,
                                    tasacion_fecha,
                                    cliente_id,
                                    tas_cliente.nombre cliente_nombre,
                                    propietario_id,
                                    tas_propietario.nombre propietario_nombre,
                                    solicitante_id,
                                    tas_solicitante.nombre solicitante_nombre,
                                    zonificacion_id,
                                    tas_zonificacion.nombre zonificacion_nombre,
                                    tas_zonificacion.abreviatura zonificacion_abreviatura,
                                    terreno_tipo_id tipo_id,
                                    tas_terreno_tipo.nombre tipo_nombre,
                                    terreno_area,
                                    terreno_valorunitario,
                                    0 edificacion_area,
                                    valor_comercial,
                                    0 valor_comercial_departamento,
                                    0 valor_ocupada,
                                    ubicacion,
                                    ubigeo_departamento.id departamento_id,
                                    ubigeo_departamento.nombre departamento_nombre,
                                    ubigeo_provincia.id provincia_id,
                                    ubigeo_provincia.nombre provincia_nombre,
                                    distrito_id,
                                    ubigeo_distrito.nombre distrito_nombre,
                                    ruta_informe,
                                    mapa_latitud,
                                    mapa_longitud
                                FROM tas_terreno
                                INNER JOIN tas_cliente ON tas_terreno.cliente_id = tas_cliente.id
                                INNER JOIN tas_propietario ON tas_terreno.propietario_id = tas_propietario.id
                                INNER JOIN tas_solicitante ON tas_terreno.solicitante_id = tas_solicitante.id
                                INNER JOIN tas_zonificacion ON tas_terreno.zonificacion_id = tas_zonificacion.id
                                INNER JOIN tas_terreno_tipo ON tas_terreno.terreno_tipo_id = tas_terreno_tipo.id
                                INNER JOIN ubigeo_distrito ON tas_terreno.distrito_id = ubigeo_distrito.id
                                INNER JOIN ubigeo_provincia ON ubigeo_distrito.provincia_id = ubigeo_provincia.id
                                INNER JOIN ubigeo_departamento ON ubigeo_provincia.departamento_id = ubigeo_departamento.id
                                UNION
                                SELECT
                                	2 categoria,
                                	tas_casa.id,
                                    informe_id,
                                    tasacion_fecha,
                                    cliente_id,
                                    tas_cliente.nombre cliente_nombre,
                                    propietario_id,
                                    tas_propietario.nombre propietario_nombre,
                                    solicitante_id,
                                    tas_solicitante.nombre solicitante_nombre,
                                    zonificacion_id,
                                    tas_zonificacion.nombre zonificacion_nombre,
                                    tas_zonificacion.abreviatura zonificacion_abreviatura,
                                    0 tipo_id,
                                    '' tipo_nombre,
                                    terreno_area,
                                    terreno_valorunitario,
                                    0 edificacion_area,
                                    valor_comercial,
                                    0 valor_comercial_departamento,
                                    0 valor_ocupada,
                                    ubicacion,
                                    ubigeo_departamento.id departamento_id,
                                    ubigeo_departamento.nombre departamento_nombre,
                                    ubigeo_provincia.id provincia_id,
                                    ubigeo_provincia.nombre provincia_nombre,
                                    distrito_id,
                                    ubigeo_distrito.nombre distrito_nombre,
                                    ruta_informe,
                                    mapa_latitud,
                                    mapa_longitud
                                FROM tas_casa
                                INNER JOIN tas_cliente ON tas_casa.cliente_id = tas_cliente.id
                                INNER JOIN tas_propietario ON tas_casa.propietario_id = tas_propietario.id
                                INNER JOIN tas_solicitante ON tas_casa.solicitante_id = tas_solicitante.id
                                INNER JOIN tas_zonificacion ON tas_casa.zonificacion_id = tas_zonificacion.id
                                INNER JOIN ubigeo_distrito ON tas_casa.distrito_id = ubigeo_distrito.id
                                INNER JOIN ubigeo_provincia ON ubigeo_distrito.provincia_id = ubigeo_provincia.id
                                INNER JOIN ubigeo_departamento ON ubigeo_provincia.departamento_id = ubigeo_departamento.id
                                UNION
                                SELECT
                                	3 categoria,
                                	tas_departamento.id,
                                    informe_id,
                                    tasacion_fecha,
                                    cliente_id,
                                    tas_cliente.nombre cliente_nombre,
                                    propietario_id,
                                    tas_propietario.nombre propietario_nombre,
                                    solicitante_id,
                                    tas_solicitante.nombre solicitante_nombre,
                                    zonificacion_id,
                                    tas_zonificacion.nombre zonificacion_nombre,
                                    tas_zonificacion.abreviatura zonificacion_abreviatura,
                                    departamento_tipo_id tipo_id,
                                    tas_departamento_tipo.nombre tipo_nombre,
                                    terreno_area,
                                    terreno_valorunitario,
                                    edificacion_area,
                                    valor_comercial,
                                    valor_comercial_departamento,
                                    valor_ocupada,
                                    ubicacion,
                                    ubigeo_departamento.id departamento_id,
                                    ubigeo_departamento.nombre departamento_nombre,
                                    ubigeo_provincia.id provincia_id,
                                    ubigeo_provincia.nombre provincia_nombre,
                                    distrito_id,
                                    ubigeo_distrito.nombre distrito_nombre,
                                    ruta_informe,
                                    mapa_latitud,
                                    mapa_longitud
                                FROM tas_departamento
                                INNER JOIN tas_cliente ON tas_departamento.cliente_id = tas_cliente.id
                                INNER JOIN tas_propietario ON tas_departamento.propietario_id = tas_propietario.id
                                INNER JOIN tas_solicitante ON tas_departamento.solicitante_id = tas_solicitante.id
                                INNER JOIN tas_zonificacion ON tas_departamento.zonificacion_id = tas_zonificacion.id
                                INNER JOIN tas_departamento_tipo ON tas_departamento.departamento_tipo_id = tas_departamento_tipo.id
                                INNER JOIN ubigeo_distrito ON tas_departamento.distrito_id = ubigeo_distrito.id
                                INNER JOIN ubigeo_provincia ON ubigeo_distrito.provincia_id = ubigeo_provincia.id
                                INNER JOIN ubigeo_departamento ON ubigeo_provincia.departamento_id = ubigeo_departamento.id
                                UNION
                                SELECT
                                	4 categoria,
                                	tas_oficina.id,
                                    informe_id,
                                    tasacion_fecha,
                                    cliente_id,
                                    tas_cliente.nombre cliente_nombre,
                                    propietario_id,
                                    tas_propietario.nombre propietario_nombre,
                                    solicitante_id,
                                    tas_solicitante.nombre solicitante_nombre,
                                    zonificacion_id,
                                    tas_zonificacion.nombre zonificacion_nombre,
                                    tas_zonificacion.abreviatura zonificacion_abreviatura,
                                    0 tipo_id,
                                    '' tipo_nombre,
                                    terreno_area,
                                    terreno_valorunitario,
                                    edificacion_area,
                                    valor_comercial,
                                    0 valor_comercial_departamento,
                                    valor_ocupada,
                                    ubicacion,
                                    ubigeo_departamento.id departamento_id,
                                    ubigeo_departamento.nombre departamento_nombre,
                                    ubigeo_provincia.id provincia_id,
                                    ubigeo_provincia.nombre provincia_nombre,
                                    distrito_id,
                                    ubigeo_distrito.nombre distrito_nombre,
                                    ruta_informe,
                                    mapa_latitud,
                                    mapa_longitud
                                FROM tas_oficina
                                INNER JOIN tas_cliente ON tas_oficina.cliente_id = tas_cliente.id
                                INNER JOIN tas_propietario ON tas_oficina.propietario_id = tas_propietario.id
                                INNER JOIN tas_solicitante ON tas_oficina.solicitante_id = tas_solicitante.id
                                INNER JOIN tas_zonificacion ON tas_oficina.zonificacion_id = tas_zonificacion.id
                                INNER JOIN ubigeo_distrito ON tas_oficina.distrito_id = ubigeo_distrito.id
                                INNER JOIN ubigeo_provincia ON ubigeo_distrito.provincia_id = ubigeo_provincia.id
                                INNER JOIN ubigeo_departamento ON ubigeo_provincia.departamento_id = ubigeo_departamento.id
                                UNION
                                SELECT
                                	5 categoria,
                                	tas_local_comercial.id,
                                    informe_id,
                                    tasacion_fecha,
                                    cliente_id,
                                    tas_cliente.nombre cliente_nombre,
                                    propietario_id,
                                    tas_propietario.nombre propietario_nombre,
                                    solicitante_id,
                                    tas_solicitante.nombre solicitante_nombre,
                                    zonificacion_id,
                                    tas_zonificacion.nombre zonificacion_nombre,
                                    tas_zonificacion.abreviatura zonificacion_abreviatura,
                                    local_tipo_id tipo_id,
                                    tas_local_tipo.nombre tipo_nombre,
                                    terreno_area,
                                    terreno_valorunitario,
                                    0 edificacion_area,
                                    valor_comercial,
                                    0 valor_comercial_departamento,
                                    valor_ocupada,
                                    ubicacion,
                                    ubigeo_departamento.id departamento_id,
                                    ubigeo_departamento.nombre departamento_nombre,
                                    ubigeo_provincia.id provincia_id,
                                    ubigeo_provincia.nombre provincia_nombre,
                                    distrito_id,
                                    ubigeo_distrito.nombre distrito_nombre,
                                    ruta_informe,
                                    mapa_latitud,
                                    mapa_longitud
                                FROM tas_local_comercial
                                INNER JOIN tas_cliente ON tas_local_comercial.cliente_id = tas_cliente.id
                                INNER JOIN tas_propietario ON tas_local_comercial.propietario_id = tas_propietario.id
                                INNER JOIN tas_solicitante ON tas_local_comercial.solicitante_id = tas_solicitante.id
                                INNER JOIN tas_zonificacion ON tas_local_comercial.zonificacion_id = tas_zonificacion.id
                                INNER JOIN tas_local_tipo ON tas_local_comercial.local_tipo_id = tas_local_tipo.id
                                INNER JOIN ubigeo_distrito ON tas_local_comercial.distrito_id = ubigeo_distrito.id
                                INNER JOIN ubigeo_provincia ON ubigeo_distrito.provincia_id = ubigeo_provincia.id
                                INNER JOIN ubigeo_departamento ON ubigeo_provincia.departamento_id = ubigeo_departamento.id
                                UNION
                                SELECT
                                	6 categoria,
                                	tas_local_industrial.id,
                                    informe_id,
                                    tasacion_fecha,
                                    cliente_id,
                                    tas_cliente.nombre cliente_nombre,
                                    propietario_id,
                                    tas_propietario.nombre propietario_nombre,
                                    solicitante_id,
                                    tas_solicitante.nombre solicitante_nombre,
                                    zonificacion_id,
                                    tas_zonificacion.nombre zonificacion_nombre,
                                    tas_zonificacion.abreviatura zonificacion_abreviatura,
                                    0 tipo_id,
                                    '' tipo_nombre,
                                    terreno_area,
                                    terreno_valorunitario,
                                    0 edificacion_area,
                                    valor_comercial,
                                    0 valor_comercial_departamento,
                                    0 valor_ocupada,
                                    ubicacion,
                                    ubigeo_departamento.id departamento_id,
                                    ubigeo_departamento.nombre departamento_nombre,
                                    ubigeo_provincia.id provincia_id,
                                    ubigeo_provincia.nombre provincia_nombre,
                                    distrito_id,
                                    ubigeo_distrito.nombre distrito_nombre,
                                    ruta_informe,
                                    mapa_latitud,
                                    mapa_longitud
                                FROM tas_local_industrial
                                INNER JOIN tas_cliente ON tas_local_industrial.cliente_id = tas_cliente.id
                                INNER JOIN tas_propietario ON tas_local_industrial.propietario_id = tas_propietario.id
                                INNER JOIN tas_solicitante ON tas_local_industrial.solicitante_id = tas_solicitante.id
                                INNER JOIN tas_zonificacion ON tas_local_industrial.zonificacion_id = tas_zonificacion.id
                                INNER JOIN ubigeo_distrito ON tas_local_industrial.distrito_id = ubigeo_distrito.id
                                INNER JOIN ubigeo_provincia ON ubigeo_distrito.provincia_id = ubigeo_provincia.id
                                INNER JOIN ubigeo_departamento ON ubigeo_provincia.departamento_id = ubigeo_departamento.id;");*/
        $query = $this->db->query("	SELECT
                                        tas_terreno.id,
                                        1 categoria,
                                        informe_id,
                                        cliente_id,
                                        cliente_tipo,
                                        IF(cliente_tipo = '', tas_cliente.nombre, IF(cliente_tipo = 'Natural', CONCAT(if(length(cli_nat.paterno)>0, concat(cli_nat.paterno, ' '),''), if(length(cli_nat.materno)>0, concat(cli_nat.materno, ' '),''), cli_nat.nombres), cli_jur.razon_social)) cliente_nombre,
                                        propietario_id,
                                        tas_propietario.nombre propietario_nombre,
                                        solicitante_id,
                                        solicitante_tipo,
                                        IF(solicitante_tipo = '', tas_solicitante.nombre, IF(solicitante_tipo = 'Natural', CONCAT(if(length(sol_nat.paterno)>0, concat(sol_nat.paterno, ' '),''), if(length(sol_nat.materno)>0, concat(sol_nat.materno, ' '),''), sol_nat.nombres), sol_jur.razon_social)) solicitante_nombre,
                                        tasacion_fecha,
                                        zonificacion_id,
                                        tas_zonificacion.abreviatura zonificacion_abreviatura,
                                        terreno_tipo_id tipo_id,
                                        tas_terreno_tipo.nombre tipo_nombre,
                                        tipo_cambio,
                                        terreno_area,
                                        terreno_valorunitario,
                                        0 edificacion_area,
                                        valor_comercial,
                                        0 clase_id,
                                        '' clase_nombre,
                                        0 marca_id,
                                        '' marca_nombre,
                                        0 modelo_id,
                                        '' modelo_nombre,
                                        0 fabricacion_anio,
                                        0 valor_similar_nuevo,
                                        0 valor_comercial_departamento,
                                        0 estacionamiento_cantidad,
                                        0 valor_ocupada,
                                        ubicacion,
                                        departamento_id,
                                        ubigeo_departamento.nombre departamento_nombre,
                                        provincia_id,
                                        ubigeo_provincia.nombre provincia_nombre,
                                        distrito_id,
                                        ubigeo_distrito.nombre distrito_nombre,
                                        0 antiguedad,
                                        mapa_latitud,
                                        mapa_longitud,
                                        observacion,
                                        ruta_informe,
                                        adjunto,
                                        tas_terreno.fecha_registro,
                                        tas_terreno.usuario_registro_id,
                                        usu.full_name usuario_registro_nombre
                                    FROM tas_terreno
                                    LEFT JOIN tas_propietario ON tas_terreno.propietario_id = tas_propietario.id
                                    LEFT JOIN tas_cliente ON tas_terreno.cliente_id = tas_cliente.id AND cliente_tipo = ''
                                    LEFT JOIN tas_solicitante ON tas_terreno.solicitante_id = tas_solicitante.id AND solicitante_tipo = ''
                                    LEFT JOIN involucrado_natural cli_nat ON tas_terreno.cliente_id = cli_nat.id AND cliente_tipo = 'Natural'
                                    LEFT JOIN involucrado_juridico cli_jur ON tas_terreno.cliente_id = cli_jur.id AND cliente_tipo = 'Juridica'
                                    LEFT JOIN involucrado_natural sol_nat ON tas_terreno.solicitante_id = sol_nat.id AND solicitante_tipo = 'Natural'
                                    LEFT JOIN involucrado_juridico sol_jur ON tas_terreno.solicitante_id = sol_jur.id AND solicitante_tipo = 'Juridica'
                                    INNER JOIN tas_zonificacion ON tas_terreno.zonificacion_id = tas_zonificacion.id
                                    INNER JOIN tas_terreno_tipo ON tas_terreno.terreno_tipo_id = tas_terreno_tipo.id
                                    INNER JOIN ubigeo_distrito ON tas_terreno.distrito_id = ubigeo_distrito.id
                                    INNER JOIN ubigeo_provincia ON ubigeo_distrito.provincia_id = ubigeo_provincia.id
                                    INNER JOIN ubigeo_departamento ON ubigeo_provincia.departamento_id = ubigeo_departamento.id
                                    INNER JOIN login_user usu ON tas_terreno.usuario_registro_id = usu.id
                                    UNION
                                    SELECT
                                        tas_casa.id,
                                        2 categoria,
                                        informe_id,
                                        cliente_id,
                                        cliente_tipo,
                                        IF(cliente_tipo = '', tas_cliente.nombre, IF(cliente_tipo = 'Natural', CONCAT(if(length(cli_nat.paterno)>0, concat(cli_nat.paterno, ' '),''), if(length(cli_nat.materno)>0, concat(cli_nat.materno, ' '),''), cli_nat.nombres), cli_jur.razon_social)) cliente_nombre,
                                        propietario_id,
                                        tas_propietario.nombre propietario_nombre,
                                        solicitante_id,
                                        solicitante_tipo,
                                        IF(solicitante_tipo = '', tas_solicitante.nombre, IF(solicitante_tipo = 'Natural', CONCAT(if(length(sol_nat.paterno)>0, concat(sol_nat.paterno, ' '),''), if(length(sol_nat.materno)>0, concat(sol_nat.materno, ' '),''), sol_nat.nombres), sol_jur.razon_social)) solicitante_nombre,
                                        tasacion_fecha,
                                        zonificacion_id,
                                        tas_zonificacion.abreviatura zonificacion_abreviatura,
                                        0 tipo_id,
                                        '' tipo_nombre,
                                        tipo_cambio,
                                        terreno_area,
                                        terreno_valorunitario,
                                        0 edificacion_area,
                                        valor_comercial,
                                        0 clase_id,
                                        '' clase_nombre,
                                        0 marca_id,
                                        '' marca_nombre,
                                        0 modelo_id,
                                        '' modelo_nombre,
                                        0 fabricacion_anio,
                                        0 valor_similar_nuevo,
                                        0 valor_comercial_departamento,
                                        0 estacionamiento_cantidad,
                                        0 valor_ocupada,
                                        ubicacion,
                                        departamento_id,
                                        ubigeo_departamento.nombre departamento_nombre,
                                        provincia_id,
                                        ubigeo_provincia.nombre provincia_nombre,
                                        distrito_id,
                                        ubigeo_distrito.nombre distrito_nombre,
                                        0 antiguedad,
                                        mapa_latitud,
                                        mapa_longitud,
                                        observacion,
                                        ruta_informe,
                                        adjunto,
                                        tas_casa.fecha_registro,
                                        tas_casa.usuario_registro_id,
                                        usu.full_name usuario_registro_nombre
                                    FROM tas_casa
                                    LEFT JOIN tas_propietario ON tas_casa.propietario_id = tas_propietario.id
                                    LEFT JOIN tas_cliente ON tas_casa.cliente_id = tas_cliente.id AND cliente_tipo = ''
                                    LEFT JOIN tas_solicitante ON tas_casa.solicitante_id = tas_solicitante.id AND solicitante_tipo = ''
                                    LEFT JOIN involucrado_natural cli_nat ON tas_casa.cliente_id = cli_nat.id AND cliente_tipo = 'Natural'
                                    LEFT JOIN involucrado_juridico cli_jur ON tas_casa.cliente_id = cli_jur.id AND cliente_tipo = 'Juridica'
                                    LEFT JOIN involucrado_natural sol_nat ON tas_casa.solicitante_id = sol_nat.id AND solicitante_tipo = 'Natural'
                                    LEFT JOIN involucrado_juridico sol_jur ON tas_casa.solicitante_id = sol_jur.id AND solicitante_tipo = 'Juridica'
                                    INNER JOIN tas_zonificacion ON tas_casa.zonificacion_id = tas_zonificacion.id
                                    INNER JOIN ubigeo_distrito ON tas_casa.distrito_id = ubigeo_distrito.id
                                    INNER JOIN ubigeo_provincia ON ubigeo_distrito.provincia_id = ubigeo_provincia.id
                                    INNER JOIN ubigeo_departamento ON ubigeo_provincia.departamento_id = ubigeo_departamento.id
                                    INNER JOIN login_user usu ON tas_casa.usuario_registro_id = usu.id
                                    UNION
                                    SELECT
                                        tas_departamento.id,
                                        3 categoria,
                                        informe_id,
                                        cliente_id,
                                        cliente_tipo,
                                        IF(cliente_tipo = '', tas_cliente.nombre, IF(cliente_tipo = 'Natural', CONCAT(if(length(cli_nat.paterno)>0, concat(cli_nat.paterno, ' '),''), if(length(cli_nat.materno)>0, concat(cli_nat.materno, ' '),''), cli_nat.nombres), cli_jur.razon_social)) cliente_nombre,
                                        propietario_id,
                                        tas_propietario.nombre propietario_nombre,
                                        solicitante_id,
                                        solicitante_tipo,
                                        IF(solicitante_tipo = '', tas_solicitante.nombre, IF(solicitante_tipo = 'Natural', CONCAT(if(length(sol_nat.paterno)>0, concat(sol_nat.paterno, ' '),''), if(length(sol_nat.materno)>0, concat(sol_nat.materno, ' '),''), sol_nat.nombres), sol_jur.razon_social)) solicitante_nombre,
                                        tasacion_fecha,
                                        zonificacion_id,
                                        tas_zonificacion.abreviatura zonificacion_abreviatura,
                                        departamento_tipo_id tipo_id,
                                        tas_departamento_tipo.nombre tipo_nombre,
                                        tipo_cambio,
                                        terreno_area,
                                        terreno_valorunitario,
                                        edificacion_area,
                                        valor_comercial,
                                        0 clase_id,
                                        '' clase_nombre,
                                        0 marca_id,
                                        '' marca_nombre,
                                        0 modelo_id,
                                        '' modelo_nombre,
                                        0 fabricacion_anio,
                                        0 valor_similar_nuevo,
                                        valor_comercial_departamento,
                                        0 estacionamiento_cantidad,
                                        valor_ocupada,
                                        ubicacion,
                                        departamento_id,
                                        ubigeo_departamento.nombre departamento_nombre,
                                        provincia_id,
                                        ubigeo_provincia.nombre provincia_nombre,
                                        distrito_id,
                                        ubigeo_distrito.nombre distrito_nombre,
                                        antiguedad,
                                        mapa_latitud,
                                        mapa_longitud,
                                        observacion,
                                        ruta_informe,
                                        adjunto,
                                        tas_departamento.fecha_registro,
                                        tas_departamento.usuario_registro_id,
                                        usu.full_name usuario_registro_nombre
                                    FROM tas_departamento
                                    LEFT JOIN tas_propietario ON tas_departamento.propietario_id = tas_propietario.id
                                    LEFT JOIN tas_cliente ON tas_departamento.cliente_id = tas_cliente.id AND cliente_tipo = ''
                                    LEFT JOIN tas_solicitante ON tas_departamento.solicitante_id = tas_solicitante.id AND solicitante_tipo = ''
                                    LEFT JOIN involucrado_natural cli_nat ON tas_departamento.cliente_id = cli_nat.id AND cliente_tipo = 'Natural'
                                    LEFT JOIN involucrado_juridico cli_jur ON tas_departamento.cliente_id = cli_jur.id AND cliente_tipo = 'Juridica'
                                    LEFT JOIN involucrado_natural sol_nat ON tas_departamento.solicitante_id = sol_nat.id AND solicitante_tipo = 'Natural'
                                    LEFT JOIN involucrado_juridico sol_jur ON tas_departamento.solicitante_id = sol_jur.id AND solicitante_tipo = 'Juridica'
                                    LEFT JOIN tas_zonificacion ON tas_departamento.zonificacion_id = tas_zonificacion.id
                                    LEFT JOIN tas_departamento_tipo ON tas_departamento.departamento_tipo_id = tas_departamento_tipo.id
                                    INNER JOIN ubigeo_distrito ON tas_departamento.distrito_id = ubigeo_distrito.id
                                    INNER JOIN ubigeo_provincia ON ubigeo_distrito.provincia_id = ubigeo_provincia.id
                                    INNER JOIN ubigeo_departamento ON ubigeo_provincia.departamento_id = ubigeo_departamento.id
                                    INNER JOIN login_user usu ON tas_departamento.usuario_registro_id = usu.id
                                    UNION
                                    SELECT
                                        tas_oficina.id,
                                        4 categoria,
                                        informe_id,
                                        cliente_id,
                                        cliente_tipo,
                                        IF(cliente_tipo = '', tas_cliente.nombre, IF(cliente_tipo = 'Natural', CONCAT(if(length(cli_nat.paterno)>0, concat(cli_nat.paterno, ' '),''), if(length(cli_nat.materno)>0, concat(cli_nat.materno, ' '),''), cli_nat.nombres), cli_jur.razon_social)) cliente_nombre,
                                        propietario_id,
                                        tas_propietario.nombre propietario_nombre,
                                        solicitante_id,
                                        solicitante_tipo,
                                        IF(solicitante_tipo = '', tas_solicitante.nombre, IF(solicitante_tipo = 'Natural', CONCAT(if(length(sol_nat.paterno)>0, concat(sol_nat.paterno, ' '),''), if(length(sol_nat.materno)>0, concat(sol_nat.materno, ' '),''), sol_nat.nombres), sol_jur.razon_social)) solicitante_nombre,
                                        tasacion_fecha,
                                        zonificacion_id,
                                        tas_zonificacion.abreviatura zonificacion_abreviatura,
                                        0 tipo_id,
                                        '' tipo_nombre,
                                        tipo_cambio,
                                        terreno_area,
                                        terreno_valorunitario,
                                        edificacion_area,
                                        valor_comercial,
                                        0 clase_id,
                                        '' clase_nombre,
                                        0 marca_id,
                                        '' marca_nombre,
                                        0 modelo_id,
                                        '' modelo_nombre,
                                        0 fabricacion_anio,
                                        0 valor_similar_nuevo,
                                        0 valor_comercial_departamento,
                                        0 estacionamiento_cantidad,
                                        valor_ocupada,
                                        ubicacion,
                                        departamento_id,
                                        ubigeo_departamento.nombre departamento_nombre,
                                        provincia_id,
                                        ubigeo_provincia.nombre provincia_nombre,
                                        distrito_id,
                                        ubigeo_distrito.nombre distrito_nombre,
                                        0 antiguedad,
                                        mapa_latitud,
                                        mapa_longitud,
                                        observacion,
                                        ruta_informe,
                                        adjunto,
                                        tas_oficina.fecha_registro,
                                        tas_oficina.usuario_registro_id,
                                        usu.full_name usuario_registro_nombre
                                    FROM tas_oficina
                                    LEFT JOIN tas_propietario ON tas_oficina.propietario_id = tas_propietario.id
                                    LEFT JOIN tas_cliente ON tas_oficina.cliente_id = tas_cliente.id AND cliente_tipo = ''
                                    LEFT JOIN tas_solicitante ON tas_oficina.solicitante_id = tas_solicitante.id AND solicitante_tipo = ''
                                    LEFT JOIN involucrado_natural cli_nat ON tas_oficina.cliente_id = cli_nat.id AND cliente_tipo = 'Natural'
                                    LEFT JOIN involucrado_juridico cli_jur ON tas_oficina.cliente_id = cli_jur.id AND cliente_tipo = 'Juridica'
                                    LEFT JOIN involucrado_natural sol_nat ON tas_oficina.solicitante_id = sol_nat.id AND solicitante_tipo = 'Natural'
                                    LEFT JOIN involucrado_juridico sol_jur ON tas_oficina.solicitante_id = sol_jur.id AND solicitante_tipo = 'Juridica'
                                    INNER JOIN tas_zonificacion ON tas_oficina.zonificacion_id = tas_zonificacion.id
                                    INNER JOIN ubigeo_distrito ON tas_oficina.distrito_id = ubigeo_distrito.id
                                    INNER JOIN ubigeo_provincia ON ubigeo_distrito.provincia_id = ubigeo_provincia.id
                                    INNER JOIN ubigeo_departamento ON ubigeo_provincia.departamento_id = ubigeo_departamento.id
                                    INNER JOIN login_user usu ON tas_oficina.usuario_registro_id = usu.id
                                    UNION
                                    SELECT
                                        tas_local_comercial.id,
                                        5 categoria,
                                        informe_id,
                                        cliente_id,
                                        cliente_tipo,
                                        IF(cliente_tipo = '', tas_cliente.nombre, IF(cliente_tipo = 'Natural', CONCAT(if(length(cli_nat.paterno)>0, concat(cli_nat.paterno, ' '),''), if(length(cli_nat.materno)>0, concat(cli_nat.materno, ' '),''), cli_nat.nombres), cli_jur.razon_social)) cliente_nombre,
                                        propietario_id,
                                        tas_propietario.nombre propietario_nombre,
                                        solicitante_id,
                                        solicitante_tipo,
                                        IF(solicitante_tipo = '', tas_solicitante.nombre, IF(solicitante_tipo = 'Natural', CONCAT(if(length(sol_nat.paterno)>0, concat(sol_nat.paterno, ' '),''), if(length(sol_nat.materno)>0, concat(sol_nat.materno, ' '),''), sol_nat.nombres), sol_jur.razon_social)) solicitante_nombre,
                                        tasacion_fecha,
                                        zonificacion_id,
                                        tas_zonificacion.abreviatura zonificacion_abreviatura,
                                        local_tipo_id tipo_id,
                                        tas_local_tipo.nombre tipo_nombre,
                                        tipo_cambio,
                                        terreno_area,
                                        terreno_valorunitario,
                                        edificacion_area,
                                        valor_comercial,
                                        0 clase_id,
                                        '' clase_nombre,
                                        0 marca_id,
                                        '' marca_nombre,
                                        0 modelo_id,
                                        '' modelo_nombre,
                                        0 fabricacion_anio,
                                        0 valor_similar_nuevo,
                                        0 valor_comercial_departamento,
                                        0 estacionamiento_cantidad,
                                        valor_ocupada,
                                        ubicacion,
                                        departamento_id,
                                        ubigeo_departamento.nombre departamento_nombre,
                                        provincia_id,
                                        ubigeo_provincia.nombre provincia_nombre,
                                        distrito_id,
                                        ubigeo_distrito.nombre distrito_nombre,
                                        0 antiguedad,
                                        mapa_latitud,
                                        mapa_longitud,
                                        observacion,
                                        ruta_informe,
                                        adjunto,
                                        tas_local_comercial.fecha_registro,
                                        tas_local_comercial.usuario_registro_id,
                                        usu.full_name usuario_registro_nombre
                                    FROM tas_local_comercial
                                    LEFT JOIN tas_propietario ON tas_local_comercial.propietario_id = tas_propietario.id
                                    LEFT JOIN tas_cliente ON tas_local_comercial.cliente_id = tas_cliente.id AND cliente_tipo = ''
                                    LEFT JOIN tas_solicitante ON tas_local_comercial.solicitante_id = tas_solicitante.id AND solicitante_tipo = ''
                                    LEFT JOIN involucrado_natural cli_nat ON tas_local_comercial.cliente_id = cli_nat.id AND cliente_tipo = 'Natural'
                                    LEFT JOIN involucrado_juridico cli_jur ON tas_local_comercial.cliente_id = cli_jur.id AND cliente_tipo = 'Juridica'
                                    LEFT JOIN involucrado_natural sol_nat ON tas_local_comercial.solicitante_id = sol_nat.id AND solicitante_tipo = 'Natural'
                                    LEFT JOIN involucrado_juridico sol_jur ON tas_local_comercial.solicitante_id = sol_jur.id AND solicitante_tipo = 'Juridica'
                                    LEFT JOIN tas_zonificacion ON tas_local_comercial.zonificacion_id = tas_zonificacion.id
                                    LEFT JOIN tas_local_tipo ON tas_local_comercial.distrito_id = tas_local_tipo.id
                                    INNER JOIN ubigeo_distrito ON tas_local_comercial.distrito_id = ubigeo_distrito.id
                                    INNER JOIN ubigeo_provincia ON ubigeo_distrito.provincia_id = ubigeo_provincia.id
                                    INNER JOIN ubigeo_departamento ON ubigeo_provincia.departamento_id = ubigeo_departamento.id
                                    INNER JOIN login_user usu ON tas_local_comercial.usuario_registro_id = usu.id
                                    UNION
                                    SELECT
                                        tas_local_industrial.id,
                                        6 categoria,
                                        informe_id,
                                        cliente_id,
                                        cliente_tipo,
                                        IF(cliente_tipo = '', tas_cliente.nombre, IF(cliente_tipo = 'Natural', CONCAT(if(length(cli_nat.paterno)>0, concat(cli_nat.paterno, ' '),''), if(length(cli_nat.materno)>0, concat(cli_nat.materno, ' '),''), cli_nat.nombres), cli_jur.razon_social)) cliente_nombre,
                                        propietario_id,
                                        tas_propietario.nombre propietario_nombre,
                                        solicitante_id,
                                        solicitante_tipo,
                                        IF(solicitante_tipo = '', tas_solicitante.nombre, IF(solicitante_tipo = 'Natural', CONCAT(if(length(sol_nat.paterno)>0, concat(sol_nat.paterno, ' '),''), if(length(sol_nat.materno)>0, concat(sol_nat.materno, ' '),''), sol_nat.nombres), sol_jur.razon_social)) solicitante_nombre,
                                        tasacion_fecha,
                                        zonificacion_id,
                                        tas_zonificacion.abreviatura zonificacion_abreviatura,
                                        0 tipo_id,
                                        '' tipo_nombre,
                                        tipo_cambio,
                                        terreno_area,
                                        terreno_valorunitario,
                                        edificacion_area,
                                        valor_comercial,
                                        0 clase_id,
                                        '' clase_nombre,
                                        0 marca_id,
                                        '' marca_nombre,
                                        0 modelo_id,
                                        '' modelo_nombre,
                                        0 fabricacion_anio,
                                        0 valor_similar_nuevo,
                                        0 valor_comercial_departamento,
                                        0 estacionamiento_cantidad,
                                        0 valor_ocupada,
                                        ubicacion,
                                        departamento_id,
                                        ubigeo_departamento.nombre departamento_nombre,
                                        provincia_id,
                                        ubigeo_provincia.nombre provincia_nombre,
                                        distrito_id,
                                        ubigeo_distrito.nombre distrito_nombre,
                                        0 antiguedad,
                                        mapa_latitud,
                                        mapa_longitud,
                                        observacion,
                                        ruta_informe,
                                        adjunto,
                                        tas_local_industrial.fecha_registro,
                                        tas_local_industrial.usuario_registro_id,
                                        usu.full_name usuario_registro_nombre
                                    FROM tas_local_industrial
                                    LEFT JOIN tas_propietario ON tas_local_industrial.propietario_id = tas_propietario.id
                                    LEFT JOIN tas_cliente ON tas_local_industrial.cliente_id = tas_cliente.id AND cliente_tipo = ''
                                    LEFT JOIN tas_solicitante ON tas_local_industrial.solicitante_id = tas_solicitante.id AND solicitante_tipo = ''
                                    LEFT JOIN involucrado_natural cli_nat ON tas_local_industrial.cliente_id = cli_nat.id AND cliente_tipo = 'Natural'
                                    LEFT JOIN involucrado_juridico cli_jur ON tas_local_industrial.cliente_id = cli_jur.id AND cliente_tipo = 'Juridica'
                                    LEFT JOIN involucrado_natural sol_nat ON tas_local_industrial.solicitante_id = sol_nat.id AND solicitante_tipo = 'Natural'
                                    LEFT JOIN involucrado_juridico sol_jur ON tas_local_industrial.solicitante_id = sol_jur.id AND solicitante_tipo = 'Juridica'
                                    INNER JOIN tas_zonificacion ON tas_local_industrial.zonificacion_id = tas_zonificacion.id
                                    INNER JOIN ubigeo_distrito ON tas_local_industrial.distrito_id = ubigeo_distrito.id
                                    INNER JOIN ubigeo_provincia ON ubigeo_distrito.provincia_id = ubigeo_provincia.id
                                    INNER JOIN ubigeo_departamento ON ubigeo_provincia.departamento_id = ubigeo_departamento.id
                                    INNER JOIN login_user usu ON tas_local_industrial.usuario_registro_id = usu.id;");

		if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
		}    
	}

	
	public function tasacionesTerreno()
    {
        $this->db->select('informe_id,
		ds.nombre solicitante, 
        dc.nombre cliente,
        dp.nombre propietario,
        ubicacion,
        DATE_FORMAT(tasacion_fecha, \'%d/%m/%y\')  FECHA,
        mapa_latitud,
        mapa_longitud,
        zonificacion,
        dct.nombre,
        round(terreno_area,2) terreno_area,
        round(terreno_valorunitario,2) terreno_valorunitario,
        round(valor_comercial,2) valor_comercial,
        ruta_informe');
        $this->db->from('t_terreno tt');
        $this->db->join('diccionario_solicitante ds', 'tt.solicitante_id = ds.id','left');
        $this->db->join('diccionario_cliente dc', 'tt.cliente_id = dc.id','left');
        $this->db->join('diccionario_propietario dp', 'tt.propietario_id = dp.id','left');
        $this->db->join('diccionario_cultivo_tipo dct', 'tt.cultivo_tipo_id = dct.id','left');
        //$this->db->where('tt.solicitante_id', '1111');
        $this->db->order_by('tasacion_fecha', 'DESC');
        $query = $this->db->get();
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
    }

    public function tasacionesDepartamento()
    {
        $this->db->select('informe_id,
		ds.nombre solicitante, 
        dc.nombre cliente,
        dp.nombre propietario,
        ubicacion,
        DATE_FORMAT(tasacion_fecha, \'%d/%m/%y\')  FECHA,
        mapa_latitud,
        mapa_longitud,
        zonificacion,
        piso_cantidad,
        dtipo.nombre depatipo,
		round(terreno_area,2) terreno_area,
        round(terreno_valorunitario,2) terreno_valorunitario,
        round(edificacion_area,2) edificacion_area,
        round(valor_comercial,2) valor_comercial,
        round(valor_ocupada,2) valor_ocupada,
        ruta_informe');
        $this->db->from('t_departamento tdepa');
        $this->db->join('diccionario_solicitante ds', 'tdepa.solicitante_id = ds.id','left');
        $this->db->join('diccionario_cliente dc', 'tdepa.cliente_id = dc.id','left');
        $this->db->join('diccionario_propietario dp', 'tdepa.propietario_id = dp.id','left');
        $this->db->join('diccionario_departamento_tipo dtipo', 'tdepa.departamento_tipo_id = dtipo.id','left');

        $this->db->order_by('tasacion_fecha', 'DESC');

        $query = $this->db->get();
        return $query->result();

        /*if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }*/
    }
    public function tasacionesCasa()
    {
        $this->db->select('informe_id,
		ds.nombre solicitante, 
        dc.nombre cliente,
        dp.nombre propietario,
        ubicacion,
        DATE_FORMAT(tasacion_fecha, \'%d/%m/%y\')  FECHA,
        mapa_latitud,
        mapa_longitud,
        zonificacion,
        piso_cantidad,
        terreno_area,
        terreno_valorunitario,
        edificacion_area,
        valor_comercial,
        ruta_informe');
        $this->db->from('t_casa tcasa');
        $this->db->join('diccionario_solicitante ds', 'tcasa.solicitante_id = ds.id','left');
        $this->db->join('diccionario_cliente dc', 'tcasa.cliente_id = dc.id','left');
        $this->db->join('diccionario_propietario dp', 'tcasa.propietario_id = dp.id','left');
        $this->db->order_by('tasacion_fecha', 'DESC');

        $query = $this->db->get();
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
    }
    public function tasacionesCasaPorCampos($match)
    {
        $this->db->select('informe_id,
		ds.nombre as solicitante, 
        dc.nombre as cliente,
        dp.nombre as propietario,
        ubicacion,
        DATE_FORMAT(tasacion_fecha, \'%d/%m/%y\')  FECHA,
        mapa_latitud,
        mapa_longitud,
        zonificacion,
        piso_cantidad,
        round(terreno_area,2) terreno_area,
        round(terreno_valorunitario,2) terreno_valorunitario,
        round(edificacion_area,2) edificacion_area,
        round(valor_comercial,2) valor_comercial,
        ruta_informe');
        $this->db->from('t_casa tcasa');
        $this->db->join('diccionario_solicitante ds', 'tcasa.solicitante_id = ds.id','left');
        $this->db->join('diccionario_cliente dc', 'tcasa.cliente_id = dc.id','left');
        $this->db->join('diccionario_propietario dp', 'tcasa.propietario_id = dp.id','left');
        $this->db->like('informe_id', $match);
        $array = array('ds.nombre' => $match, 'dc.nombre' => $match, 'dp.nombre' => $match, 'ubicacion' => $match);
        $this->db->or_like($array);
        $this->db->order_by('tasacion_fecha', 'DESC');
        

        $query = $this->db->get();
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
    }
    public function tasacionesLocalComercial()
    {
        $this->db->select('informe_id,
		ds.nombre solicitante, 
        dc.nombre cliente,
        dp.nombre propietario,
        ubicacion,
        DATE_FORMAT(tasacion_fecha, \'%d/%m/%y\')  FECHA,
        mapa_latitud,
        mapa_longitud,
        zonificacion,
        piso_cantidad,
        dvl.nombre vistalocal,
        round(terreno_area,2) terreno_area,
        round(terreno_valorunitario,2) terreno_valorunitario,
        round(edificacion_area,2) edificacion_area,
        round(valor_comercial,2) valor_comercial,
        round(valor_ocupada,2) valor_ocupada,
        ruta_informe');
        $this->db->from('t_local_comercial tlocal');
        $this->db->join('diccionario_solicitante ds', 'tlocal.solicitante_id = ds.id','left');
        $this->db->join('diccionario_cliente dc', 'tlocal.cliente_id = dc.id','left');
        $this->db->join('diccionario_propietario dp', 'tlocal.propietario_id = dp.id','left');
        $this->db->join('diccionario_vista_local dvl', 'tlocal.vista_local_id = dvl.id','left');
        $this->db->order_by('tasacion_fecha', 'DESC');
        $query = $this->db->get();
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
    }
    public function tasacionesLocalIndustrial()
    {
        $this->db->select('informe_id,
		ds.nombre solicitante, 
        dc.nombre cliente,
        dp.nombre propietario,
        ubicacion,
        DATE_FORMAT(tasacion_fecha, \'%d/%m/%y\')  FECHA,
        mapa_latitud,
        mapa_longitud,
        zonificacion,
        piso_cantidad,
        round(terreno_area,2) terreno_area,
        round(terreno_valorunitario,2) terreno_valorunitario,
        round(edificacion_area,2) edificacion_area,
        round(valor_comercial,2) valor_comercial,
        areas_complementarias,
        ruta_informe');
        $this->db->from('t_local_industrial tlocalindustrial');
        $this->db->join('diccionario_solicitante ds', 'tlocalindustrial.solicitante_id = ds.id','left');
        $this->db->join('diccionario_cliente dc', 'tlocalindustrial.cliente_id = dc.id','left');
        $this->db->join('diccionario_propietario dp', 'tlocalindustrial.propietario_id = dp.id','left');
        $this->db->order_by('tasacion_fecha', 'DESC');
        $query = $this->db->get();
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
    }
    public function tasacionesOficina()
    {
        $this->db->select('informe_id,
		ds.nombre solicitante, 
        dc.nombre cliente,
        dp.nombre propietario,
        ubicacion,
        DATE_FORMAT(tasacion_fecha, \'%d/%m/%y\')  FECHA,
        mapa_latitud,
        mapa_longitud,
        zonificacion,
        piso_cantidad,
        piso_ubicacion,
        ddt.nombre,        
        round(terreno_area,2) terreno_area,
        round(terreno_valorunitario,2) terreno_valorunitario,
        round(edificacion_area,2) edificacion_area,
        round(valor_comercial,2) valor_comercial,
        ruta_informe');
        $this->db->from('t_oficina oficina');
        $this->db->join('diccionario_solicitante ds', 'oficina.solicitante_id = ds.id','left');
        $this->db->join('diccionario_cliente dc', 'oficina.cliente_id = dc.id','left');
        $this->db->join('diccionario_propietario dp', 'oficina.propietario_id = dp.id','left');
        $this->db->join('diccionario_departamento_tipo ddt', 'oficina.departamento_tipo_id = ddt.id','left');
        $this->db->order_by('tasacion_fecha', 'DESC');
        $query = $this->db->get();
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
    }

    public function listarZonificacion()
    {
        $query = $this->db->get("in_zonificacion");
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
    }
    public function listarDepartamento()
    {
        $query = $this->db->get("ubi_departamento");
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
    }
    public function listarProvincia($idDep)
    {
        $this->db->where('departamento_id', $idDep);
        $query = $this->db->get('ubi_provincia');
        //$query = $this->db->get_where('ubi_provincia', array('departamento_id' => $idDep));
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
    }
    public function listarDistrito($idProv)
    {
        $query = $this->db->get_where('ubi_distrito', array('provincia_id' => $idProv));
        if($query->num_rows()> 0){
            return $query->result();
        }
        else{
            return false;
        }
    }
}