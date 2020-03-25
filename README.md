# Scandiweb_KlarnaGraphQl

This module extends Magento 2 Klarna GraphQl definitions.

## Configuration

In order for Klarna to work, check that country of your store and selected currency corresponds to the following table:

| Country        | Currency |
| -------------- | -------- |
| Austria        | EUR      |
| Denmark        | DKK      |
| Finland        | EUR      |
| Germany        | EUR      |
| Netherlands    | EUR      |
| Norway         | NOK      |
| Sweden         | SEK      |
| United Kingdom | GBP      |
| United States  | USD      |

Check that you have set according values in `Stores -> Configuration -> `:
 - `General -> General -> Default Country`
 - `General -> Currency Setup -> Currency Options`

Afterwards, configure Klarna in `Stores -> Configuration -> Sales -> Payment Methods -> Klarna`
