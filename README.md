# stitchlite
stitchie stitch. Is only integrated with Shopify. Built with Phalcon framework. You will have to install phalcon
to run this project locally. Get phalcon here http://phalconphp.com/en/download

Syncing is only one way. stitchlite db's state will be synced to Shopify via sync api but not the other way round.

# POST /api/sync: 
Syncs all active sales channels to pull in new products to StitchLite, and update products on each channel.
example : http://stitchlite.com/api/sync

# GET /api/products: 
returns all products stored in StitchLite.
example : http://stitchlite.com/api/products

# GET /api/products/__PRODUCT_ID__: 
returns the specified product in StitchLite.
example : http://stitchlite.com/api/products/416523201

# GET /shopify/products:
Pull in products from Shopify and store them as StitchLite products
example : http://stitchlite.com/shopify/products

# GET /shopify:
authentication with shopify private app
example : http://stitchlite.com/shopify