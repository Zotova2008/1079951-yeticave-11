  <main>
      <nav class="nav">
          <ul class="nav__list container">
              <?php foreach ($category as $cat) : ?>
                  <li class="nav__item">
                      <a href="pages/all-lots.html"><?= $cat['category_name']; ?></a>
                  </li>
              <?php endforeach; ?>
          </ul>
      </nav>
      <div class="container">
          <section class="lots">
              <h2>Результаты поиска по запросу «<span><?= $search ?></span>»</h2>
              <?php if (empty($lots)) : ?>
                  <p>Ничего не найдено по вашему запросу</p>
              <?php endif ?>
              <ul class="lots__list">
                  <?php foreach ($lots as $item) : ?>
                      <li class="lots__item lot">
                          <div class="lot__image">
                              <img src="<?= $item['lot_img']; ?>" width="350" height="260" alt="<?= $item['lot_title']; ?>">
                          </div>
                          <div class="lot__info">
                              <span class="lot__category"><?= $item['category_name']; ?></span>
                              <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?= $item['id']; ?>"><?= $item['lot_title']; ?></a></h3>
                              <div class="lot__state">
                                  <div class="lot__rate">
                                      <span class="lot__amount">Стартовая цена</span>
                                      <span class="lot__cost"><?= $item['lot_price']; ?><b class="rub">р</b></span>
                                  </div>
                                  <?php $time_array = get_time($item['date_final']); ?>
                                  <div class="lot__timer timer <?php if ($time_array[0] < $limit_time) : ?>timer--finishing<?php endif; ?>">
                                      <?= ($time_array[0] . ' : ' . $time_array[1]); ?>
                                  </div>
                              </div>
                          </div>
                      </li>
                  <?php endforeach; ?>
              </ul>
          </section>
          <ul class="pagination-list">
              <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
              <li class="pagination-item pagination-item-active"><a>1</a></li>
              <li class="pagination-item"><a href="#">2</a></li>
              <li class="pagination-item"><a href="#">3</a></li>
              <li class="pagination-item"><a href="#">4</a></li>
              <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
          </ul>
      </div>
  </main>
