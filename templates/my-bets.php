  <main>
      <nav class="nav">
          <ul class="nav__list container">
              <?php foreach ($category as $cat) : ?>
                  <li class="nav__item">
                      <a href="all-lots.html"><?= $cat['category_name']; ?></a>
                  </li>
              <?php endforeach; ?>
          </ul>
      </nav>

      <section class="rates container">
          <h2>Мои ставки</h2>
          <table class="rates__list">
              <?php foreach ($lots as $item) : ?>
                  <tr class="rates__item">
                      <td class="rates__info">
                          <div class="rates__img">
                              <img src="<?= $item['lot_img']; ?>" width="54" height="40" alt="<?= $item['lot_title']; ?>">
                          </div>
                          <h3 class="rates__title"><a href="lot.php?id=<?= $item['id']; ?>"><?= $item['lot_title']; ?></a></h3>
                      </td>
                      <td class="rates__category">
                          <?= ($item['category_name']); ?>
                      </td>
                      <td class="rates__timer">
                          <?php $time_array = get_time($item['date_final']); ?>
                          <div class="lot-item__timer timer <?php if ($time_array[0] < $limit_time) : ?>timer--finishing<?php endif; ?>">
                              <?= implode(':', $time_array); ?>
                          </div>
                      </td>
                      <td class="rates__price">
                          <?= ($item['bet_price']); ?> р
                      </td>
                      <td class="rates__time">
                          <?= get_time_since_adding($item['bet_time']) ?? implode(' в ', explode(' ', $item['time_format'])); ?>
                      </td>
                  </tr>
              <?php endforeach; ?>
          </table>
      </section>
  </main>
