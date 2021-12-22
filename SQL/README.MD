Как сделать что-то в цикле
```mariadb
DELIMITER //
CREATE PROCEDURE groupss () begin
DECLARE i INT DEFAULT 1;
WHILE i<60000 DO
INSERT INTO seo_sitemap_pages (UF_URL) Values ('test/url');
SET i=i+1;
END WHILE;
end //

CALL groupss();
```
! Цикл - это программа, он не заработает без процедуры.
