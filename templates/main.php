<main class="container">
    <section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
        <ul class="promo__list">

            <?php foreach ($category as $category) : ?>
                <li class="promo__item promo__item--<?= $category['symbol_cat']; ?>">
                    <a class="promo__link" href="pages/all-lots.html"><?= $category['category_name']; ?></a>
                </li>
            <?php endforeach; ?>

        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
        </div>
        <ul class="lots__list">

            <?php foreach ($ads as $ads) : ?>
                <li class="lots__item lot">
                    <div class="lot__image">
                        <img src="<?= $ads['lot_img']; ?>" width="350" height="260" alt="<?= $ads['lot_title']; ?>">
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?= $ads['category_name']; ?></span>
                        <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?= $ads['id']; ?>"><?= $ads['lot_title']; ?></a></h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount">Стартовая цена</span>
                                <span class="lot__cost"><?= format_amount($ads['lot_price']); ?></span>
                            </div>
                            <?php $time_array = get_time($ads['date_final']); ?>
                            <div class="lot__timer timer <?php if ($time_array[0] < $limit_time) : ?>timer--finishing<?php endif; ?>">
                                <?= ($time_array[0] . ' : ' . $time_array[1]); ?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>

        </ul>
    </section>
</main>
