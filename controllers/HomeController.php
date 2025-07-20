<?php
// Fix duplicate categories in featured categories
class HomeController extends BaseController {

    public function index() {
        $productModel = new Product();
        $categoryModel = new Category();
        // Get featured products
        $featuredProducts = $productModel->getFeatured(8);

        // Get categories
        $categories = $categoryModel->getAll();

        // Remove duplicates and limit to 5 categories
        $uniqueCategories = [];
        $seenIds = [];
        foreach ($categories as $category) {
            if (!in_array($category['id'], $seenIds)) {
                $uniqueCategories[] = $category;
                $seenIds[] = $category['id'];
            }
            if (count($uniqueCategories) >= 5) {
                break;
            }
        }

        $this->render('home/index', [
            'featuredProducts' => $featuredProducts,
            'categories' => $uniqueCategories
        ]);
    }
}
?>