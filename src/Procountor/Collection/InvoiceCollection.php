<?php

namespace Procountor\Procountor\Collection;

use Procountor\Procountor\Interfaces\ListResult;
use Procountor\Procountor\Interfaces\Read\Invoice;
use Procountor\Procountor\Resources\AbstractResourceRequest;
use Procountor\Procountor\Response\Invoice as ResponseInvoice;
use stdClass;
use TypeError;


class InvoiceCollection extends AbstractCollection implements ListResult
{

    /** @var Invoice[] $items */
    protected array $items;
    protected int $total;
    protected int $perPage;
    protected int $currentPage;
    protected ?AbstractResourceRequest $resource;


    public function __construct(stdClass $response, ?AbstractResourceRequest &$resource = null)
    {
        $this->items = array_map(
            fn (stdClass $item): ResponseInvoice => new ResponseInvoice($item),
            $response->results
        );
        $this->total = (int)$response->meta->resultCount;
        $this->perPage = (int)$response->meta->pageSize;
        $this->currentPage = (int)$response->meta->pageNumber;
        $this->resource = $resource;
    }

    public function addItem($item): AbstractCollection
    {
        if (!($item instanceof Invoice)) {
            throw new TypeError('InvoiceCollection expects instances of Invoices');
        }

        $this->items[] = $item;
        return $this;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getItemsPerPage(): int
    {
        return $this->perPage;
    }

}
