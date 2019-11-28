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
        <section class="lot-item container">
            <h2><?= $lot['lot_title']; ?></h2>
            <div class="lot-item__content">
                <div class="lot-item__left">
                    <div class="lot-item__image">
                        <img src="<?= $lot['lot_img']; ?>" width="730" height="548" alt="<?= $lot['lot_title']; ?>">
                    </div>
                    <p class="lot-item__category">Категория: <span><?= $lot['category_name']; ?></span></p>
                    <p class="lot-item__description"><?= $lot['lot_descript']; ?></p>
                </div>
                <div class="lot-item__right">
                    <?php if (isset($_SESSION['user'])) : ?>
                        <div class="lot-item__state">
                            <?php $time_array = get_time($lot['date_final']); ?>
                            <div class="lot-item__timer timer <?php if ($time_array[0] < $limit_time) : ?>timer--finishing<?php endif; ?>">
                                <?= implode(':', $time_array); ?>
                            </div>
                            <div class="lot-item__cost-state">
                                <div class="lot-item__rate">
                                    <span class="lot-item__amount">Текущая цена</span>
                                    <span class="lot-item__cost"><?= $lot['bet_sum'] ?? $lot['lot_price']; ?></span>
                                </div>
                                <div class="lot-item__min-cost">
                                    Мин. ставка <span><?= $lot['bet_sum'] ? ($lot['bet_sum'] + $lot['lot_step']) : ($lot['lot_price'] + $lot['lot_step']); ?></span>
                                </div>
                            </div>

                            <form class="lot-item__form" action="<?= 'lot.php?id=' . $lot['id'] ?>" method="post" autocomplete="off">
                                <?php $classname = isset($errors['cost']) ? "form__item--invalid" : ""; ?>
                                <p class="lot-item__form-item form__item <?= $classname; ?>">
                                    <label for="cost">Ваша ставка</label>
                                    <input id="cost" type="text" name="cost" placeholder="<?= $lot['bet_sum'] ? ($lot['bet_sum'] + $lot['lot_step']) : ($lot['lot_price'] + $lot['lot_step']); ?>" value="<?= $_POST['cost'] ?? ''; ?>">
                                    <span class="form__error"><?= $errors['cost'] ?></span>
                                </p>
                                <button type="submit" class="button">Сделать ставку</button>
                            </form>

                        </div>
                    <?php endif ?>

                    <div class="history">
                        <h3>История ставок (<span>10</span>)</h3>
                        <table class="history__list">
                            <tbody>
                                <?php foreach ($history as $his) : ?>
                                    <tr class="history__item">
                                        <td class="history__name"><?= $his['user_name']; ?></td>
                                        <td class="history__price"><?= $his['bet_sum']; ?> р</td>
                                        <td class="history__time"><?= format_bet_date($his['bet_time']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>
