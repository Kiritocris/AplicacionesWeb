CREATE PROCEDURE GastosPorAnioDetalle(IN user_id INT, IN anio INT)
BEGIN
    CREATE TEMPORARY TABLE MesesDelAnio (
        mes_num INT PRIMARY KEY,
        mes_nombre VARCHAR(20)
    )

    INSERT INTO MesesDelAnio (mes_num, mes_nombre)
    VALUES
        (1, "Enero")
        (2, 'Febrero') 
        (3, 'Marzo')
        (4, 'Abril') 
        (5, 'Mayo') 
        (6, 'Junio')
        (7, 'Julio') 
        (8, 'Agosto') 
        (9, 'Septiembre')
        (10, 'Octubre') 
        (11, 'Noviembre') 
        (12, 'Diciembre')

    SELECT m.mes_nombre AS mes,
           IFNULL(SUM(f.monto), 0) AS total_gastos
    FROM MesesDelAnio m
    LEFT JOIN Factura f ON MONTH(f.fecha) = m.mes_num
    LEFT JOIN Articulo a ON f.articulo_id = a.id
    WHERE a.user_id = user_id AND YEAR(f.fecha) = anio
    GROUP BY m.mes_num, m.mes_nombre
    ORDER BY m.mes_num;

    DROP TEMPORARY TABLE MesesDelAnio;
END 