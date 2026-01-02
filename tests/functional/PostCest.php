<?php

namespace tests\functional;

use FunctionalTester;
use app\models\Post;

class PostCest
{
    public function _before(FunctionalTester $I)
    {
        // Очищаємо таблицю перед кожним тестом
        Post::deleteAll();

        // Додаємо 2 опубліковані пости (published=1)
        $p1 = new Post([
            'title' => 'Тестова новина 1',
            'text' => 'Текст новини 1',
            'category_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'published' => 1,

        ]);
        $p1->save(false);

        $p2 = new Post([
            'title' => 'Тестова новина 2',
            'text' => 'Текст новини 2',
            'category_id' => 2,
            'created_at' => date('Y-m-d H:i:s'),
            'published' => 1,

        ]);
        $p2->save(false);
    }

    /** Тест: сторінка відкривається */
    public function openNewsPage(FunctionalTester $I)
    {
        $I->amOnPage('/post/index');
        $I->seeResponseCodeIs(200);
        $I->see('ІТ-Новини');
    }

    /* Тест: пости з БД видно на сторінці */
    public function postsAreVisible(FunctionalTester $I)
    {
        $I->amOnPage('/post/index');

        $I->see('Тестова новина 1');
        $I->see('Тестова новина 2');

        $I->see('Текст новини 1');
        $I->see('Текст новини 2');
    }

    /** Тест: неопубліковані (published=0) не показуються */
    public function unpublishedPostHidden(FunctionalTester $I)
    {
        $hidden = new Post([
            'title' => 'Прихована новина',
            'text' => 'Її не повинно бути видно',
            'category_id' => 1,
            'published' => 0,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        $hidden->save(false);

        $I->amOnPage('/post/index');
        $I->dontSee('Прихована новина');
    }

    /* Тест: пагінація існує і перехід на 2 сторінку працює */
    public function paginationWorks(FunctionalTester $I)
    {
        // Створюємо багато постів, щоб була пагінація 
        for ($i = 1; $i <= 10; $i++) {
            $p = new Post([
                'title' => 'Новина ' . $i,
                'text' => 'Текст ' . $i,
                'category_id' => 1,
                'published' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            $p->save(false);
        }

        $I->amOnPage('/post/index');
        $I->seeElement('.pagination');

        $I->amOnPage('/post/index?page=1');
        $I->seeResponseCodeIs(200);
    }
}
