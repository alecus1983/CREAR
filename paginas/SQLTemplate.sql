/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  AnaPolonia
 * Created: 6/08/2016
 */

/*consulta para establecer los docentes que enseñan en los diferentes cursos
durante un año*/

SELECT D.nombres, D.apellidos, G.grado, M.year, T.materia
FROM ((
matricula_docente M
INNER JOIN docentes D ON M.id_d = D.id
)
INNER JOIN grados G ON G.id = M.id_g
)
INNER JOIN materia T ON T.id = M.id_m

WHERE M.year =2016
ORDER BY G.id, M.id_g
