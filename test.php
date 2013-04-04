<?php
header('Content-type: application/json');
    echo '{
    "users": [
        {
            "id": 123,
            "name": "Ed",
            "orders": [
                {
                    "id": 50,
                    "total": 100,
                    "order_items": [
                        {
                            "id"      : 20,
                            "price"   : 40,
                            "quantity": 2,
                            "product" : {
                                "id": 1000,
                                "name": "MacBook Pro"
                            }
                        },
                        {
                            "id"      : 21,
                            "price"   : 20,
                            "quantity": 3,
                            "product" : {
                                "id": 1001,
                                "name": "iPhone"
                            }
                        }
                    ]
                }
            ]
        }
    ]
}';
?>