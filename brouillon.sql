SELECT k.name,
COUNT(p.id) AS nbPerson FROM Person p
RIGHT JOIN Kingdom k
ON p.kingdom_id=k.id
GROUP BY k.id;

SELECT st.name AS tagName, COUNT(s.id)
AS nbSerie FROM serie AS s
RIGHT JOIN style_tag as st
ON st_id=st.id
GROUP BY st.id;

SELECT serie_id AS favSerie, COUNT(style_tag_id)
FROM user_serie AS us
INNER JOIN serie ON us.favSerie = serie.id
INNER JOIN serie_style_tag ON serie.id = serie_style_tag.serie_id;


-- sélectionner les séries non visionnées appartenant au tag préféré (max de séries de ce tag ajoutées à l'étagère) de l'utilisateur

SELECT * FROM serie WHERE id NOT IN (SELECT serie_id FROM user_serie WHERE user_id=:user_id);
