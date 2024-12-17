<?php
if (!file_exists('data.lock')) {
    include 'data.php';
    file_put_contents('data.lock', 'Données insérées.');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue de Produits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Catalogue de Produits</h1>
        <div class="row" id="product-list">
            <!-- Les produits seront ajoutés ici -->
        </div>
        <div class="text-center my-4" id="loading" style="display: none;">
            <p>Chargement...</p>
        </div>
    </div>
    <script>
        let offset = 0;
        const limit = 20;
        const productList = document.getElementById('product-list');
        const loading = document.getElementById('loading');
        let loadingInProgress = false;

        const loadProducts = async () => {
            if (loadingInProgress) return;

            loadingInProgress = true;
            loading.style.display = 'block';

            try {
                const response = await fetch(`products.php?limit=${limit}&offset=${offset}`);
                const products = await response.json();

                products.forEach(product => {
                    const productCard = `
                        <div class="col-md-4">
                            <div class="card">
                                <img src="${product.image_url}" class="card-img-top" alt="${product.name}">
                                <div class="card-body">
                                    <h5 class="card-title">${product.name}</h5>
                                    <p class="card-text">${product.description}</p>
                                    <p class="card-text"><strong>${product.price} €</strong></p>
                                </div>
                            </div>
                        </div>
                    `;
                    productList.insertAdjacentHTML('beforeend', productCard);
                });

                offset += limit;
            } catch (error) {
                console.error('Erreur de chargement des produits :', error);
            } finally {
                loading.style.display = 'none';
                loadingInProgress = false;
            }
        };

        window.addEventListener('scroll', () => {
            if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 100) {
                loadProducts();
            }
        });

        document.addEventListener('DOMContentLoaded', loadProducts);
    </script>
</body>
</html>
