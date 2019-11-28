  <main>
      <nav class="nav">
          <ul class="nav__list container">
              <?php foreach ($category as $cat) : ?>
                  <li class="nav__item">
                      <a href="category.php?id=<?= $cat['id'] ?>"><?= $cat['category_name']; ?></a>
                  </li>
              <?php endforeach; ?>
          </ul>
      </nav>

      <section class="rates container">
          <?php if (!empty($bets)) : ?>
              <h2>Мои ставки</h2>
              <table class="rates__list">
                  <?php foreach ($bets as $item) : ?>
                      <tr class="rates__item <?php if ($item['id_user_winner'] === (int) $cur_user_id) : ?> rates__item--win
                      <?php elseif (($item['id_user_winner'] > 0) && (time() > strtotime($item['date_final']))) : ?> rates__item--end
                      <?php endif; ?>">
                          <td class="rates__info">
                              <div class="rates__img">
                                  <img src="<?= $item['lot_img']; ?>" width="54" height="40" alt="<?= $item['lot_title']; ?>">
                              </div>
                              <h3 class="rates__title"><a href="lot.php?id=<?= $item['id']; ?>"><?= $item['lot_title']; ?></a></h3>
                              <?php if ($item['id_user_winner'] === (int) $cur_user_id) : ?>
                                  <p><?= $item['user_contact']; ?></p>
                              <?php endif; ?>
                          </td>
                          <td class="rates__category">
                              <?= ($item['category_name']); ?>
                          </td>
                          <td class="rates__timer">
                              <?php if ($item['id_user_winner'] === (int) $cur_user_id) : ?>
                                  <div class="timer timer--win">Ставка выиграла</div>
                              <?php elseif (($item['id_user_winner'] > 0) && (time() > strtotime($item['date_final']))) : ?>
                                  <div class="timer timer--end">Торги окончены</div>
                              <?php else : ?>
                                  <?php $time_array = get_time($item['date_final']); ?>
                                  <div class="lot-item__timer timer <?php if ($time_array[0] < $limit_time) : ?>timer--finishing<?php endif; ?>">
                                      <?= implode(':', $time_array); ?>
                                  </div>
                              <?php endif; ?>
                          </td>
                          <td class="rates__price">
                              <?= ($item['bet_price']); ?> р
                          </td>
                          <td class="rates__time">
                              <?= format_bet_date($item['bet_time']) ?? implode(' в ', explode(' ', $item['time_format'])); ?>
                          </td>
                      </tr>
                  <?php endforeach; ?>
              </table>
          <?php endif; ?>
      </section>
  </main>
