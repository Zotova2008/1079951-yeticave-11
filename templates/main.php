<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
    <ul class="promo__list">

        <?php foreach ($categories as $value) : ?>
            <li class="promo__item promo__item--boards">
                <a class="promo__link" href="pages/all-lots.html"><?= $value; ?></a>
            </li>
        <?php endforeach; ?>

    </ul>
</section>
<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
    </div>
    <ul class="lots__list">

        <?php foreach ($ads as $item) : ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?= $item['img']; ?>" width="350" height="260" alt="">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?= $item['category']; ?></span>
                    <h3 class="lot__title"><a class="text-link" href="pages/lot.html"><?= $item['title']; ?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost"><?= format_amount($item['price']); ?></span>
                        </div>
                        <?php $time_array = get_time($item['date']); ?>
                        <div class="lot__timer timer <?php if ($time_array[0] < $limit_time) : ?>timer--finishing<?php endif; ?>">
                            <?= ($time_array[0] . ' : ' . $time_array[1]); ?>
                        </div>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>

    </ul>
</section>
