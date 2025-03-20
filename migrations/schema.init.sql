create table if not exists products
(
    id int auto_increment primary key,
    uuid  varchar(255) not null comment 'UUID товара', /* TODO: разве для UUID нужно 255 символов ? Достаточно 36 */
    category  varchar(255) not null comment 'Категория товара',
    is_active tinyint default 1  not null comment 'Флаг активности',
    name text default '' not null comment 'Тип услуги',
    description text null comment 'Описание товара',
    thumbnail  varchar(255) null comment 'Ссылка на картинку', /* TODO: теоретически ссылка может быть и длиннее, чем 255 ? */
    price int not null comment 'Цена'
)
    comment 'Товары';
