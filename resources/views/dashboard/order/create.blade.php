@extends('dashboard.layouts.main')
@section('content')
<style>
    .code{
        top: 50%;
        margin-top: 10rem;
    }
</style>
<div class="mt-3 row g-3">
    <div class="col">
            <div class="m-5">
                <input type="text" class="form-control" placeholder="Code" id="code" name="code">
            </div>
            <div class="m-5" id="suggestion">
                <input type="text" class="form-control" placeholder="Name" id="name" name="name" oninput="suggestion(this.value)" list="productslist">
            </div>
    </div>
    <table class="table col" id="orderstable">
        <thead>
            <tr>
                <th>Item</th>
                <th>Harga/barang</th>
                <th>Jumlah</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody id="tabody" name="tabody"></tbody>
    </table>
    <p class="text-end" id="grandtotal"></p>
    <button class="btn btn-primary align-self-end ms-auto" id="btncheckout" style="width: 150px" data-bs-toggle="modal" data-bs-target="#modalcheckout">Checkout</button>

    <div class="modal fade" id="modalcheckout" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form onsubmit="handleCheckout(event)">
                @csrf
                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token">
                <div class="mb-3">
                    <label for="" class="form-label">Total</label>
                    <input type="text" readonly name="total" id="total" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Payment Method</label>
                    <select name="payment" id="payment" class="form-select">
                        <option value="cash" selected>Cash</option>
                        <option value="kredit">Kredit</option>
                        <option value="debit">Debit</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Nilai Uang</label>
                    <input class="form-control" type="text" name="pay_amount" id="pay_amount">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Kasir</label>
                    <input class="form-control" type="text" name="cashier" id="cashier">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
          </div>
        </div>
    </div>

</div>
<script>
    const code = document.getElementById('code');
    const tablebody = document.getElementById('tabody');
    const grandtotal = document.getElementById('grandtotal');

    const fetching = async (val) => {
        const response = await fetch(`/dashboard/products/${val}/take`);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return await response.json();
    }
    
    const processProduct = (products) => {
        const memory = JSON.parse(localStorage.getItem('cart')) || [];
        const cartData = {
            id: products.product.id,
            item: products.product.merk + ' ' + products.product.name,
            price: products.product.sell_price,
            quantity: 1,
        }
        const cekItem = memory.find(item => item.id === products.product.id);
        if (cekItem !== undefined) {
            cekItem.quantity += 1;
        } else {
            memory.push(cartData);
        }
        localStorage.setItem('cart', JSON.stringify(memory));
        return memory;
    }

    const handleQuantity = (id, quantity) => {
        const memory = JSON.parse(localStorage.getItem('cart')) || [];
        const cekItem = memory.find(item => item.id === id);
        if (cekItem !== -1) {
            const currentQuantity = cekItem.quantity;
            const newQuantity = currentQuantity + quantity;
            if (newQuantity == 0) {
                cekItem.quantity = 1;
            } else {
                cekItem.quantity = newQuantity;
            }
            localStorage.setItem('cart', JSON.stringify(memory));
        }
        renderData(memory);
    }

    const handleDelete = (id) => {
        const memory = JSON.parse(localStorage.getItem('cart')) || [];
        const newMemory = memory.filter(item => item.id !== id);
        localStorage.setItem('cart', JSON.stringify(newMemory));
        renderData(newMemory);
    }

    const renderData = (products) => {
        tablebody.innerHTML = '';
        products.forEach(product => {
            const row = document.createElement('tr');
            row.setAttribute('data-id', product.id);
            row.innerHTML = `
                <td>${product.item}</td>
                <td>${product.price}</td>
                <td class="quantity">${product.quantity}</td>
                <td class="total">${product.price * product.quantity}</td>
                <td>
                    <div>
                        <button class="btn badge rounded-pill text-bg-info" onclick="handleQuantity(${product.id}, 1)">+</button>
                        <button class="btn badge rounded-pill text-bg-info" onclick="handleQuantity(${product.id}, -1)">-</button>
                    </div>
                    <button class="btn badge rounded-pill text-bg-warning" onclick="handleDelete(${product.id})">Hapus</button>
                </td>
            `;
            tablebody.appendChild(row);
        });
        calculateTotal();
    }

    code.addEventListener('input', async (event) => {
        const val = event.target.value;
        if (val.length == 13){
           try {
                const products = await fetching(val);
                const updateProduct = processProduct(products);
                renderData(updateProduct);
                code.value = '';
           } catch (error) {
                console.error(error);
           }
        }
    });

    function suggestion(str){
        if (str.length == 0) {
            document.getElementById("productslist").innerHTML = "";
            return;
        } else {
            const xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    const data = JSON.parse(this.responseText);
                    // const data = this.responseText;
                    let list;
                    Object.entries(data).forEach(([key, value]) => {
                        value.forEach(val => {
                            list = document.createElement('p');
                            list.setAttribute('class', 'btn badge rounded-pill text-bg-light')
                            list.setAttribute('id', 'productslist')
                            list.setAttribute('style', 'cursor: pointer;')

                            const item = `${val.merk} ${val.name}`;
                            list.innerHTML = item;

                            list.onclick = () => {
                                const memory = JSON.parse(localStorage.getItem('cart')) || [];
                                const cartData = {
                                    id: val.id,
                                    item: val.merk + ' ' + val.name,
                                    price: val.sell_price,
                                    quantity: 1,
                                }
                                const cekItem = memory.find(item => item.id === val.id);
                                if (cekItem !== undefined) {
                                    cekItem.quantity += 1;
                                } else {
                                    memory.push(cartData);
                                }
                                localStorage.setItem('cart', JSON.stringify(memory))
                                renderData(memory);
                                document.getElementById("name").value = '';
                                list.remove();
                            }
                        })

                    });

                    const existingDatalist = document.getElementById('productslist');
                    if (existingDatalist) {
                        existingDatalist.parentNode.replaceChild(list, existingDatalist);
                    } else {
                        const suggestion = document.getElementById('suggestion');
                        suggestion.appendChild(list);
                    }
                }
            };
            xmlhttp.open("GET", `/dashboard/products/suggestion/${str}`, true);
            xmlhttp.send();
        }
    }


    function calculateTotal() {
        const memory = JSON.parse(localStorage.getItem('cart')) || [];
        const total = memory.reduce((total, item) => total + item.price * item.quantity, 0);
        document.getElementById('total').value = total;
        grandtotal.innerHTML = `Total: Rp. ${total}`;
    }

    const getFullDate = () => {
      const date = new Date();
      const fulldate = date.getDate().toString() + (date.getMonth() + 1).toString() + date.getFullYear().toString();
      return fulldate;
    }
    const random = Math.floor(Math.random() * 10000).toString();

    function handleCheckout(event) {
        event.preventDefault();
        const memory = JSON.parse(localStorage.getItem('cart')) || [];
        const data = {
            invoice: "INV-" + getFullDate() + random.padStart(5, '0'),
            total: document.getElementById('total').value,
            cashier: document.getElementById('cashier').value,
            payment: document.getElementById('payment').value,
            pay_amount: document.getElementById('pay_amount').value,
            order: memory
        }
        // const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        fetch('/dashboard/orders', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.getElementById('_token').value,
            },
            body: JSON.stringify(data),
        });
        
        const orderid = data.order;
        const updateStorage = memory.filter(item => !orderid.some(o => o.id == item.id));
        localStorage.setItem('cart', JSON.stringify(updateStorage));
        window.location.href = '/dashboard/orders';
    }
</script>

@endsection