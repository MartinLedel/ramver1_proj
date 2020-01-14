Ramverk1 examination project
==================================

[![Build Status](https://travis-ci.org/MartinLedel/ramverk1-module.svg?branch=master)](https://travis-ci.org/MartinLedel/ramverk1-module)
[![CircleCI](https://circleci.com/gh/MartinLedel/ramverk1-module.svg?style=svg)](https://circleci.com/gh/MartinLedel/ramverk1-module)

[![Build Status](https://scrutinizer-ci.com/g/MartinLedel/ramverk1-module/badges/build.png?b=master)](https://scrutinizer-ci.com/g/MartinLedel/ramverk1-module/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/MartinLedel/ramverk1-module/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/MartinLedel/ramverk1-module/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/MartinLedel/ramverk1-module/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/MartinLedel/ramverk1-module/?branch=master)

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/c702bccb174a44e7800f444e91fe157b)](https://www.codacy.com/manual/MartinLedel/ramverk1-module?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=MartinLedel/ramverk1-module&amp;utm_campaign=Badge_Grade)

Clone repo
------------------------------------

git clone git@github.com:MartinLedel/ramverk1_proj.git

Install necessary packages with composer
------------------------------------

1.  `composer update`

2.  `make install`

MySQL setup
------------------------------------

Run this in the root directory: `mysql -u{root user} -p{your password} < sql/ddl/setup.sql`

Make a duplicate of `config/database_sample.php` to `config/database.php` and change the values as you see fit.

License
------------------

This software carries a MIT license. See [LICENSE.txt](LICENSE.txt) for details.

```text
 .  
..:  Copyright (c) Martin Ledel
```
