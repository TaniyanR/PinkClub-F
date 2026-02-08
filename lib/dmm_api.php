        $connectTimeoutValue = filter_var($api['connect_timeout'] ?? null, FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 1, 'max_range' => 30],
        ]);
        if ($connectTimeoutValue !== false) {
            $connectTimeout = $connectTimeoutValue;
        }

        $timeoutValue = filter_var($api['timeout'] ?? null, FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 5, 'max_range' => 60],
        ]);
        if ($timeoutValue !== false) {
            $timeout = $timeoutValue;
        }
