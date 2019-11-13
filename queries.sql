/* Добавляем список категорий; */
INSERT INTO category
  (category_name, symbol_cat)
VALUES
  ('Доски и лыжи', 'boards'),
  ('Крепления', 'attachment'),
  ('Ботинки', 'boots'),
  ('Одежда', 'clothing'),
  ('Инструменты', 'tools'),
  ('Разное', 'other');

/* Добавляем список пользователей */
INSERT INTO user_data
(user_name, user_password, user_email, user_contact, date_registr)
VALUES
  ('Иван', '11vany12', 'vany@yandex.ru', 'Москва, +79111112244', '2019-11-01 10:15:45'),
  ('Петр', '11122255', 'petrysha@gmail.com', 'Вологда, +79215554785', '2019-10-15 12:05:10'),
  ('Наталья', '2019', 'natalya@rambler.ru', 'Сочи, +79212583669', '2019-09-28 20:12:58');

/* Добавляем список объявлений */
INSERT INTO lot
(lot_title, lot_descript, lot_img, lot_price, lot_step, date_creation, id_category, id_user)
VALUES
  ('2014 Rossignol District Snowboard', 'Сноуборд Rossignol District 2019 года выпуска', 'img/lot-1.jpg', 10999, 1000, '2019-10-05 16:00:55', 1, 1),
  ('DC Ply Mens 2016/2017 Snowboard', 'Сноуборд DC Ply Mens победа на соревнованиях 2016/2017 вам обеспечена', 'img/lot-2.jpg', 159999, 10000, '2019-10-10 10:00:00', 1, 1),
  ('Крепления Union Contact Pro 2015 года размер L/XL', 'Крепления фирмы Union Contact Pro 2015 года, есть только размер L/XL', 'img/lot-3.jpg', 8000, 1000, '2019-11-01 12:00:00', 2, 2),
  ('Ботинки для сноуборда DC Mutiny Charocal', 'К сноуборду нужно преобрести ботинки фирмы DC Mutiny Charocal', 'img/lot-4.jpg', 10999, 1000, '2019-11-05 13:00:00', 3, 2),
  ('Куртка для сноуборда DC Mutiny Charocal', 'В куртке Charocal вы не замерзнете даже при +30', 'img/lot-5.jpg', 7500, 500, '2019-10-30 10:00:00', 4, 3),
  ('Маска Oakley Canopy', 'Маска защитит вас от комаров, мух и всяких летающих и ползающих паразитов', 'img/lot-6.jpg', 5400, 200, '2019-11-07 15:00:00', 6, 3);

/* Добавляем ставки для существующих объявлений */
INSERT INTO bet
(id_user, id_lot, bet_sum)
VALUES
  (1, 3, 9000),
  (3, 3, 10000),
  (2, 6, 5600);

/* получить все категории; */
SELECT * FROM category;

/* получить самые новые, открытые лоты. Каждый лот должен включать название, стартовую цену, ссылку на изображение, текущую цену, название категории */
SELECT lot.lot_title, lot.lot_price, lot.lot_img, bet.bet_sum, cat.category_name
FROM lot
  INNER JOIN category cat ON lot.id_category = cat.id
  LEFT JOIN bet ON lot.id = bet.id_lot
WHERE lot.date_final > CURRENT_TIMESTAMP;

/* показать лот по его id. Получите также название категории, к которой принадлежит лот; */
SELECT lot.id, lot.lot_title, lot.lot_descript, lot.lot_img, lot.lot_price, lot.lot_step, lot.date_creation, lot.date_final, lot.id_category, lot.id_user, lot.id_user_winner
FROM lot
  INNER JOIN category cat
  ON lot.id_category = cat.id
WHERE lot.id = 3;

/* обновить название лота по его идентификатору; */
UPDATE lot
SET lot_title = '2019 Rossignol District Snowboard'
WHERE id = 1;

/* получить список ставок для лота по его идентификатору с сортировкой по дате. */
SELECT * FROM bet
  INNER JOIN lot ON bet.id_lot = lot.id
WHERE lot.id = 3 ORDER BY bet.bet_time DESC;

