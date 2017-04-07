<?php

namespace Saritasa\Transformers\Traits;

use App\Models\Support\CursorRequest;
use App\Models\Support\PagingInfo;
use Illuminate\Http\Request;

const PAGE_SIZE = 'per_page';
const API_MAX_LIMIT = 'api.maxLimit';
const API_DEFAULT_LIMIT = 'api.defaultLimit';

trait PaginatedOutput
{
    /**
     * Read request paging data
     *
     * If checking value specified, allows only integer positive value equal or less 100 (setting).
     * If value not specified, take the default value from settings.
     *
     * @param Request $request raw request data
     * @return PagingInfo
     */
    protected function readPaging(Request $request): PagingInfo
    {
        $input = $request->only(PagingInfo::KEYS);
        if (isset($input[PAGE_SIZE])) {
            $pageSize = (int)$input[PAGE_SIZE];
            if ($pageSize <= 0) {
                $input[PAGE_SIZE] = config(API_MAX_LIMIT);
            }
            if ($pageSize > config(API_MAX_LIMIT)) {
                $input[PAGE_SIZE] = config(API_MAX_LIMIT);
            }
        }
        return new PagingInfo($input);
    }

    protected function readCursor(Request $request): CursorRequest
    {
        $input = $request->only(CursorRequest::KEYS);
        if (isset($input[PAGE_SIZE])) {
            $pageSize = (int)$input[PAGE_SIZE];
            if ($pageSize <= 0) {
                $input[PAGE_SIZE] = config(API_DEFAULT_LIMIT);
            }
            if ($pageSize > config(API_MAX_LIMIT)) {
                $input[PAGE_SIZE] = config(API_MAX_LIMIT);
            }
        }
        return new CursorRequest($input);
    }
}