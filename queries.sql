INSERT INTO category
  (title, symbol)
VALUES
  ('Доски и лыжи', 'boards'),
  ('Крепления', 'attachment'),
  ('Ботинки', 'boots'),
  ('Одежда', 'clothing'),
  ('Инструменты', 'tools'),
  ('Разное', 'other');

INSERT INTO user_data
  (registr_date, email, user, password, contact)
VALUES
  ('2019-11-01 10:15:45', 'vany@yandex.ru', 'Иван', '11vany12', 'Москва, +79111112244'),
  ('2019-10-15 12:05:10', 'petrysha@gmail.com', 'Петр', '11122255', 'Вологда, +79215554785'),
  ('2019-09-28 20:12:58', 'natalya@rambler.ru', 'Наталья', '2019', 'Сочи, +79212583669');

INSERT INTO lot
  (user_id, category_id, user_win_id, title, descript, img, starting_price, starting_date, step)
VALUES
  (1, 1, 2, 'Rossignol District Snowboard', 'Сноуборд Rossignol District 2014 года выпуска', 'img/lot-1.jpg', 10999, '2019-10-05 16:00:55', 1000),
  (1, 1, 3, 'DC Ply Mens Snowboard', 'Сноуборд DC Ply Mens победа на соревнованиях 2016/2017 вам обеспечена', 'img/lot-2.jpg', 159999, '2019-10-10 10:00:00', 10000),
  (2, 2, 1, 'Крепления Union Contact Pro', 'Крепления фирмы Union Contact Pro 2015 года, есть только размер L/XL', 'img/lot-3.jpg', 8000, '2019-11-01 12:00:00', 1000),
  (2, 3, 2, 'Ботинки DC Mutiny Charocal', 'К сноуборду нужно преобрести ботинки фирмы DC Mutiny Charocal', 'img/lot-4.jpg', 10999, '2019-11-05 13:00:00', 1000),
  (3, 4, 3, 'Куртка DC Mutiny Charocal', 'В куртке Charocal вы не замерзнете даже при +30', 'img/lot-5.jpg', 7500, '2019-10-30 10:00:00', 1000),
  (3, 6, 1, 'Маска Oakley Canopy', 'Маска защитит вас от комаров, мух и всяких летающих и ползающих паразитов', 'img/lot-6.jpg', 5400, '2019-11-07 15:00:00', 1000);

INSERT INTO bet
  (user_id, lot_id, bet_time, bet_sum)
VALUES
  (1, 2, '2019-11-01 12:00:15', 11000),
  (2, 3, '2019-11-01 13:00:00', 9000);

SELECT *
FROM category;

SELECT l.title, l.starting_price, l.img, l.step, l.ending_date, cat.title
FROM lot l
  INNER JOIN category cat
  ON l.category_id = cat.id
WHERE ending_date > NOW();

SELECT l.title
FROM lot l
  INNER JOIN category cat
  ON l.category_id = cat.id
WHERE l.id = 3;

UPDATE lot
SET title = 'RossignolSnow'
WHERE id = 1;

SELECT lot.title, bet.bet_time, bet.bet_sum
FROM bet
  INNER JOIN lot
  ON bet.lot_id = lot.id
WHERE lot.id = 1
ORDER BY bet.bet_time;

