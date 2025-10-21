@if ($paginator->hasPages())
<div class="mt-4">
    <nav
      class="d-flex justify-items-center justify-content-between"
    >
      <div
        class="d-flex justify-content-between flex-fill d-sm-none"
      >
        <ul class="pagination">
          <li class="page-item">
            <a
              class="page-link"
              href="transactions-12.html?page=1"
              rel="prev"
              >&laquo; Previous</a
            >
          </li>

          <li class="page-item">
            <a
              class="page-link"
              href="transactions-2.html?page=3"
              rel="next"
              >Next &raquo;</a
            >
          </li>
        </ul>
      </div>

      <div
        class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between"
      >
        <div>
          <p class="small text-muted">
            Showing
            <span class="fw-semibold">21</span>
            to
            <span class="fw-semibold">40</span>
            of
            <span class="fw-semibold">427</span>
            results
          </p>
        </div>

        <div>
          <ul class="pagination">
            <li class="page-item">
              <a
                class="page-link"
                href="transactions-12.html?page=1"
                rel="prev"
                aria-label="&laquo; Previous"
                >&lsaquo;</a
              >
            </li>

            <li class="page-item">
              <a
                class="page-link"
                href="transactions-12.html?page=1"
                >1</a
              >
            </li>
            <li class="page-item active" aria-current="page">
              <span class="page-link">2</span>
            </li>
            <li class="page-item">
              <a class="page-link" href="transactions-2.html?page=3"
                >3</a
              >
            </li>
            <li class="page-item">
              <a class="page-link" href="transactions-3.html?page=4"
                >4</a
              >
            </li>
            <li class="page-item">
              <a class="page-link" href="transactions-4.html?page=5"
                >5</a
              >
            </li>
            <li class="page-item">
              <a class="page-link" href="transactions-5.html?page=6"
                >6</a
              >
            </li>
            <li class="page-item">
              <a class="page-link" href="transactions-6.html?page=7"
                >7</a
              >
            </li>
            <li class="page-item">
              <a class="page-link" href="transactions-7.html?page=8"
                >8</a
              >
            </li>
            <li class="page-item">
              <a class="page-link" href="transactions-8.html?page=9"
                >9</a
              >
            </li>
            <li class="page-item">
              <a
                class="page-link"
                href="transactions-9.html?page=10"
                >10</a
              >
            </li>

            <li class="page-item disabled" aria-disabled="true">
              <span class="page-link">...</span>
            </li>

            <li class="page-item">
              <a
                class="page-link"
                href="transactions-10.html?page=21"
                >21</a
              >
            </li>
            <li class="page-item">
              <a
                class="page-link"
                href="transactions-11.html?page=22"
                >22</a
              >
            </li>

            <li class="page-item">
              <a
                class="page-link"
                href="transactions-2.html?page=3"
                rel="next"
                aria-label="Next &raquo;"
                >&rsaquo;</a
              >
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </div>
@endif

testing
