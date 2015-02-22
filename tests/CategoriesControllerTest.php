<?php
use TypiCMS\Modules\Categories\Models\Category;

class CategoriesControllerTest extends TestCase
{

    public function testAdminIndex()
    {
        $response = $this->call('GET', 'admin/categories');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testStoreFails()
    {
        $input = array('fr.title' => 'test', 'fr.slug' => '');
        $this->call('POST', 'admin/categories', $input);
        $this->assertRedirectedToRoute('admin.categories.create');
        $this->assertSessionHasErrors('fr.slug');
    }

    public function testStoreSuccess()
    {
        $object = new Category;
        $object->id = 1;
        Category::shouldReceive('create')->once()->andReturn($object);
        $input = array('fr.title' => 'test', 'fr.slug' => 'test');
        $this->call('POST', 'admin/categories', $input);
        $this->assertRedirectedToRoute('admin.categories.edit', array('id' => 1));
    }

    public function testStoreSuccessWithRedirectToList()
    {
        $object = new Category;
        $object->id = 1;
        Category::shouldReceive('create')->once()->andReturn($object);
        $input = array('fr[title]' => 'test', 'fr[slug]' => 'test', 'exit' => true);
        $this->call('POST', 'admin/categories', $input);
        $this->assertRedirectedToRoute('admin.categories.index');
    }

}
