create table articulos(
    id int auto_increment primary key,
    nombre varchar(100) unique not null,
    precio decimal(5,2),
    imagen varchar(200) default "/img/default.png",
    enVenta enum("SI", "NO") default "SI" 
);

-- VAlores de prueba
insert into articulos(nombre, precio, enVenta) values("Lapiz USB 32gb", 34.56, "SI");
insert into articulos(nombre, precio, enVenta) values("Lapiz USB 64gb", 44.56, "SI");
insert into articulos(nombre, precio, enVenta) values("Lapiz USB 128gb", 50, "NO");
insert into articulos(nombre, imagen ,precio) values("Monitor Led 19","/img/monitor1.png" ,34.56);