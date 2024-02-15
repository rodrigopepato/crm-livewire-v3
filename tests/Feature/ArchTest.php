<?php

test('globls')
    ->expect(['dd', 'dump', 'ds'])
    ->not()->toBeUsed();
