<?php
class ProductController extends BaseController {
    
    public function index() {
        $productModel = new Product();
        
        // Get filter parameters
        $category = $_GET['category'] ?? '';
        $priceRange = $_GET['price_range'] ?? '';
        $search = $_GET['search'] ?? '';
        $sort = $_GET['sort'] ?? 'name';
        
        $products = $productModel->getFiltered($category, $search, $sort);
        $categories = $productModel->getCategories();
        
        $this->render('products/index', [
            'products' => $products,
            'categories' => $categories,
            'currentCategory' => $category,
            'currentPriceRange' => $priceRange,
            'currentSearch' => $search,
            'currentSort' => $sort
        ]);
    }
    
    public function show($id) {
        $productModel = new Product();
        $product = $productModel->getById($id);
        
        if (!$product) {
            $_SESSION['error'] = 'Product not found';
            redirect('?controller=products');
        }
        
        // Get related products (same category)
        $relatedProducts = $productModel->getRelated($product['category_id'], $id, 4);
        
        $this->render('products/show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ]);
    }
    
    public function search() {
        $query = $_GET['q'] ?? '';
        
        if (empty($query)) {
            redirect('?controller=products');
        }
        
        $productModel = new Product();
        $products = $productModel->search($query);
        
        $this->render('products/search', [
            'products' => $products,
            'query' => $query
        ]);
    }
}
?>