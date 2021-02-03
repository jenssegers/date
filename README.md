Date
====

[![Latest Stable Version](http://img.shields.io/github/release/jenssegers/date.svg)](https://packagist.org/packages/jenssegers/date) [![Total Downloads](http://img.shields.io/packagist/dm/jenssegers/date.svg)](https://packagist.org/packages/jenssegers/date) [![Build Status](http://img.shields.io/travis/jenssegers/date.svg)](https://travis-ci.org/jenssegers/date) [![Coverage Status](https://coveralls.io/repos/github/jenssegers/date/badge.svg?branch=master)](https://coveralls.io/github/jenssegers/date?branch=master) [![Donate](https://img.shields.io/badge/donate-paypal-blue.svg)](https://www.paypal.me/jenssegers)

This date library extends [Carbon](https://github.com/briannesbitt/Carbon) with multi-language support. Methods such as `format`, `diffForHumans`, `parse`, `createFromFormat` and the new `timespan`, will now be translated based on your locale.

> All translations made by contributors have been moved to the Carbon 2 package. This package now uses the Carbon translations to provide you with better multi-language support. Translation issues should be reported on the [Carbon repository](https://github.com/briannesbitt/Carbon). Please also check out the original documentation [here](https://carbon.nesbot.com/docs).

Installation
------------

Install using composer:

```bash
composer require jenssegers/date
```

Laravel
-------

There is a service provider included for integration with the Laravel framework. This provider will get the application locale setting and use this for translations. This service will be automatically registered if you use Laravel 5.5+ using the auto-discovery. Else to register the service provider, add the following to the providers array in `config/app.php`:

```php
Jenssegers\Date\DateServiceProvider::class,
```

You can also add it as a Facade in `config/app.php`:

```php
'Date' => Jenssegers\Date\Date::class,
```

Languages
---------

This package contains language files for the following languages (https://carbon.nesbot.com/docs/#supported-locales):

- Afar (aa)
- Afrikaans (af)
- Aghem (agq)
- Aguaruna (agr)
- Akan (ak)
- Amharic (am)
- Aragonese (an)
- Angika (anp)
- Arabic (ar)
- Assamese (as)
- Asu (asa)
- Asturian (ast)
- Southern Aymara (ayc)
- Azerbaijani (az)
- Basaa (bas)
- Belarusian (be)
- Bemba (bem)
- ber (ber)
- Bena (bez)
- Bulgarian (bg)
- Bhili (bhb)
- Bhojpuri (bho)
- Bislama (bi)
- Bambara (bm)
- Bengali (bn)
- Tibetan (bo)
- Breton (br)
- Bodo (brx)
- Bosnian (bs)
- Bilin (byn)
- Catalan (ca)
- Chakma (ccp)
- Chechen (ce)
- Chiga (cgg)
- Cherokee (chr)
- Chinese (cmn)
- Crimean Turkish (crh)
- Czech (cs)
- Kashubian (csb)
- Church Slavic (cu)
- Chuvash (cv)
- Welsh (cy)
- Danish (da)
- Taita (dav)
- German (de)
- Zarma (dje)
- Dogri (macrolanguage) (doi)
- Lower Sorbian (dsb)
- Duala (dua)
- Divehi (dv)
- Jola-Fonyi (dyo)
- Dzongkha (dz)
- Embu (ebu)
- Ewe (ee)
- Greek (modern) (el)
- English (en)
- Esperanto (eo)
- Spanish (es)
- Estonian (et)
- Basque (eu)
- Ewondo (ewo)
- Persian (fa)
- Fulah (ff)
- Finnish (fi)
- Filipino (fil)
- Faroese (fo)
- French (fr)
- Friulian (fur)
- Western Frisian (fy)
- Irish (ga)
- Gaelic (gd)
- Geez (gez)
- Galician (gl)
- Konkani (gom)
- Swiss German (gsw)
- Gujarati (gu)
- Gusii (guz)
- Manx (gv)
- Hausa (ha)
- Hakka Chinese (hak)
- Hawaiian (haw)
- Hebrew (modern) (he)
- Hindi (hi)
- Fiji Hindi (hif)
- Chhattisgarhi (hne)
- Croatian (hr)
- Upper Sorbian (hsb)
- Haitian (ht)
- Hungarian (hu)
- Armenian (hy)
- i18n (i18n)
- Interlingua (ia)
- Indonesian (id)
- Igbo (ig)
- Sichuan Yi (ii)
- Inupiaq (ik)
- in (in)
- Icelandic (is)
- Italian (it)
- Inuktitut (iu)
- iw (iw)
- Japanese (ja)
- Ngomba (jgo)
- Machame (jmc)
- Javanese (jv)
- Georgian (ka)
- Kabyle (kab)
- Kamba (kam)
- Makonde (kde)
- Kabuverdianu (kea)
- Koyra Chiini (khq)
- Kikuyu (ki)
- Kazakh (kk)
- Kako (kkj)
- Kalaallisut (kl)
- Kalenjin (kln)
- Central Khmer (km)
- Kannada (kn)
- Korean (ko)
- Konkani (kok)
- Kashmiri (ks)
- Shambala (ksb)
- Bafia (ksf)
- Colognian (ksh)
- Kurdish (ku)
- Cornish (kw)
- Kirghiz (ky)
- Langi (lag)
- Luxembourgish (lb)
- Ganda (lg)
- Limburgan (li)
- Ligurian (lij)
- Lakota (lkt)
- Lingala (ln)
- Lao (lo)
- Northern Luri (lrc)
- Lithuanian (lt)
- Luba-Katanga (lu)
- Luo (luo)
- Luyia (luy)
- Latvian (lv)
- Literary Chinese (lzh)
- Magahi (mag)
- Maithili (mai)
- Masai (mas)
- Meru (mer)
- Morisyen (mfe)
- Malagasy (mg)
- Makhuwa-Meetto (mgh)
- Metaʼ (mgo)
- Eastern Mari (mhr)
- Maori (mi)
- Mískito (miq)
- Karbi (mjw)
- Macedonian (mk)
- Malayalam (ml)
- Mongolian (mn)
- Manipuri (mni)
- mo (mo)
- Marathi (mr)
- Malay (ms)
- Maltese (mt)
- Mundang (mua)
- Burmese (my)
- Mazanderani (mzn)
- Min Nan Chinese (nan)
- Nama (naq)
- Norwegian Bokmål (nb)
- North Ndebele (nd)
- Low German (nds)
- Nepali (ne)
- Central Nahuatl (nhn)
- Niuean (niu)
- Dutch (nl)
- Kwasio (nmg)
- Norwegian Nynorsk (nn)
- Ngiemboon (nnh)
- Norwegian (no)
- South Ndebele (nr)
- Northern Sotho (nso)
- Nuer (nus)
- Nyankole (nyn)
- Occitan (oc)
- Oromo (om)
- Oriya (or)
- Ossetian (os)
- Panjabi (pa)
- Papiamento (pap)
- Polish (pl)
- Prussian (prg)
- Pashto (ps)
- Portuguese (pt)
- Quechua (qu)
- Cusco Quechua (quz)
- Rajasthani (raj)
- Romansh (rm)
- Rundi (rn)
- Romanian (ro)
- Rombo (rof)
- Russian (ru)
- Kinyarwanda (rw)
- Rwa (rwk)
- Sanskrit (sa)
- Sakha (sah)
- Samburu (saq)
- Santali (sat)
- Sangu (sbp)
- Sardinian (sc)
- Sindhi (sd)
- Northern Sami (se)
- Sena (seh)
- Koyraboro Senni (ses)
- Sango (sg)
- Samogitian (sgs)
- sh (sh)
- Tachelhit (shi)
- Shan (shn)
- Shuswap (shs)
- Sinhala (si)
- Sidamo (sid)
- Slovak (sk)
- Slovene (sl)
- Samoan (sm)
- Inari Sami (smn)
- Shona (sn)
- Somali (so)
- Albanian (sq)
- Serbian (sr)
- Swati (ss)
- Southern Sotho (st)
- Swedish (sv)
- Swahili (sw)
- Silesian (szl)
- Tamil (ta)
- Tulu (tcy)
- Telugu (te)
- Teso (teo)
- Tetum (tet)
- Tajik (tg)
- Thai (th)
- Chitwania Tharu (the)
- Tigrinya (ti)
- Tigre (tig)
- Turkmen (tk)
- Tagalog (tl)
- Klingon (tlh)
- Tswana (tn)
- Tongan (Tonga Islands) (to)
- Tok Pisin (tpi)
- Turkish (tr)
- Tsonga (ts)
- Tatar (tt)
- Tasawaq (twq)
- Talossan (tzl)
- Tamazight (tzm)
- Uighur (ug)
- Ukrainian (uk)
- Unami (unm)
- Urdu (ur)
- Uzbek (uz)
- Vai (vai)
- Venda (ve)
- Vietnamese (vi)
- Volapük (vo)
- Vunjo (vun)
- Walloon (wa)
- Walser (wae)
- Wolaytta (wal)
- Wolof (wo)
- Xhosa (xh)
- Soga (xog)
- Yangben (yav)
- Yiddish (yi)
- Yoruba (yo)
- Cantonese (yue)
- Yau (Morobe Province) (yuw)
- Standard Moroccan Tamazight (zgh)
- Chinese (zh)
- Zulu (zu)

Usage
-----

The Date class extends the Carbon methods such as `format` and `diffForHumans`, and translates them based on your locale:

```php
use Jenssegers\Date\Date;

Date::setLocale('nl');

echo Date::now()->format('l j F Y H:i:s'); // zondag 28 april 2013 21:58:16

echo Date::parse('-1 day')->diffForHumans(); // 1 dag geleden
```

The Date class also added some aliases and additional methods such as: `ago` which is an alias for `diffForHumans`, and the `timespan` method:

```php
echo $date->timespan(); // 3 months, 1 week, 1 day, 3 hours, 20 minutes
```

Methods such as `parse` and `createFromFormat` also support "reverse translations". When calling these methods with translated input, it will try to translate it to English before passing it to DateTime:

```php
$date = Date::createFromFormat('l d F Y', 'zaterdag 21 maart 2015');
```

Carbon
------

Carbon is the library the Date class is based on. All of the original Carbon operations are still available, check out <https://carbon.nesbot.com/docs> for more information. Here are some of the available methods:

### Creating dates

You can create Date objects just like the DateTime object (<http://www.php.net/manual/en/datetime.construct.php>):

```php
$date = new Date();
$date = new Date('2000-01-31');
$date = new Date('2000-01-31 12:00:00');

// With time zone
$date = new Date('2000-01-31', new DateTimeZone('Europe/Brussels'));
```

You can skip the creation of a DateTimeZone object:

```php
$date = new Date('2000-01-31', 'Europe/Brussels');
```

Create Date objects from a relative format (<http://www.php.net/manual/en/datetime.formats.relative.php>):

```php
$date = new Date('now');
$date = new Date('today');
$date = new Date('+1 hour');
$date = new Date('next monday');
```

This is also available using these static methods:

```php
$date = Date::parse('now');
$date = Date::now();
```

Creating a Date from a timestamp:

```php
$date = new Date(1367186296);
```

Or from an existing date or time:

```php
$date = Date::createFromDate(2000, 1, 31);
$date = Date::createFromTime(12, 0, 0);
$date = Date::create(2000, 1, 31, 12, 0, 0);
```

### Formatting Dates

You can format a Date object like the DateTime object (<http://www.php.net/manual/en/function.date.php>):

```php
echo Date::now()->format('Y-m-d'); // 2000-01-31
```

The Date object can be cast to a string:

```php
echo Date::now(); // 2000-01-31 12:00:00
```

Get a human readable output (alias for diffForHumans):

```php
echo $date->ago(); // 5 days ago
```

Calculate a timespan:

```php
$date = new Date('+1000 days');
echo Date::now()->timespan($date);
// 2 years, 8 months, 3 weeks, 5 days

// or even
echo Date::now()->timespan('+1000 days');
```

Get years since date:

```php
$date = new Date('-10 years');
echo $date->age; // 10

$date = new Date('+10 years');
echo $date->age; // -10
```

### Manipulating Dates

You can manipulate by using the *add* and *sub* methods, with relative intervals (<http://www.php.net/manual/en/datetime.formats.relative.php>):

```php
$yesterday = Date::now()->sub('1 day');
$tomorrow  = Date::now()->add('1 day');

// ISO 8601
$date = Date::now()->add('P2Y4DT6H8M');
```

You can access and modify all date attributes as an object:

```php
$date->year = 2013:
$date->month = 1;
$date->day = 31;

$date->hour = 12;
$date->minute = 0;
$date->second = 0;
```

## Contributing

Language contributions should made to <https://github.com/briannesbitt/Carbon>.

## License

Laravel Date is licensed under [The MIT License (MIT)](LICENSE).

## Security contact information

To report a security vulnerability, follow [these steps](https://tidelift.com/security).
