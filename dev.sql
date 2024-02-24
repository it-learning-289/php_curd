-- UPDATE tiendata.shoes SET categories =  'nike' WHERE id=2;
SELECT COUNT(*), categories
FROM shoes
GROUP BY categories;


SELECT 
--     *
    table_name AS `Table`,
    ROUND(SUM(data_length)) AS `Size_B`
FROM information_schema.tables 
WHERE table_schema = 'tiendata' 
    AND table_name = 'shoes';


OPTIMIZE TABLE shoes;
SHOW TABLE STATUS;
show TABLE STATUS LIKE 'shoes';





SELECT 
COUNT(*) 
-- *
from 
(SELECT shoes.id, shoes.name ,shoes.price , category.name AS categories
FROM shoes
INNER JOIN category   ON shoes.categories=category.id) tmp;
-- where categories is null;
-- ORDER BY shoes.CustomerName;


SELECT
    shoes.id,
    shoes.name,
    shoes.price,
    category.name AS categories
FROM
    shoes
    INNER JOIN category ON shoes.categories = category.id
WHERE
    id = 4;




INSERT INTO shoes (name, price, categories)
VALUES ('h20','213','3');

