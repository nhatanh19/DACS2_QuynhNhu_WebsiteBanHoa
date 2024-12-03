document.addEventListener('DOMContentLoaded', function() {
    // Xử lý thêm vào giỏ hàng
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', async function() {
            const productId = this.dataset.productId;
            const quantity = 1; // Mặc định số lượng là 1

            try {
                const response = await fetch('add_to_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: quantity
                    })
                });

                const result = await response.json();
                
                if (result.success) {
                    // Hiển thị thông báo thành công
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: 'Đã thêm sản phẩm vào giỏ hàng',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    // Cập nhật số lượng sản phẩm trong giỏ hàng trên header
                    updateCartCount();
                } else {
                    // Hiển thị thông báo lỗi
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: result.message || 'Không thể thêm sản phẩm vào giỏ hàng'
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: 'Đã có lỗi xảy ra, vui lòng thử lại sau'
                });
            }
        });
    });

    // Hàm cập nhật số lượng sản phẩm trong giỏ hàng
    async function updateCartCount() {
        try {
            const response = await fetch('get_cart_count.php');
            const result = await response.json();
            
            if (result.success) {
                const cartCountElement = document.querySelector('.cart-count');
                if (cartCountElement) {
                    cartCountElement.textContent = result.count;
                }
            }
        } catch (error) {
            console.error('Error updating cart count:', error);
        }
    }
});
