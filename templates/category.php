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
    <div class="container">
        <section class="lots">
            <h2>Все лоты в категории «<span><?= $category_name; ?></span>»</h2>
            <?php if (empty($lots)) : ?>
                <p>В данного категории нет лотов</p>
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
                                    <span class="lot__cost"><?= format_amount($item['lot_price']); ?></span>
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

        <?php if ($pages_count > 1) : ?>
            <? $cat['id'] = $category_id; ?>
            <ul class="pagination-list">

                <li class="pagination-item pagination-item-prev <?php if ($page_prev == 0) : ?>pagination-no-active<?php endif; ?>"><a href="category.php?id=<?= $cat['id'] ?>&page=<?= $page_prev; ?>">Назад</a></li>

                <?php foreach ($pages as $page) : ?>
                    <li class="pagination-item <?php if ($page == $cur_page) : ?>pagination-item-active<?php endif; ?>">
                        <a href="category.php?id=<?= $cat['id'] ?>&page=<?= $page; ?>"><?= $page; ?></a>
                    </li>
                <?php endforeach; ?>

                <li class="pagination-item pagination-item-next <?php if (!$page_next) : ?>pagination-no-active<?php endif; ?>"><a href="category.php?id=<?= $cat['id'] ?>&page=<?= $page_next; ?>">Вперед</a></li>

            </ul>
        <?php endif; ?>

    </div>
</main>
