<div class="main-content" data-simplebar="">
    <div class="row g-4 mb-4">
        <div class="col-lg-4">
            <div class="i-card-sm p-3">
                <div class="i-card-sm card-style rounded-3">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="title text--purple mb-4">Investment</h5>
                        <div class="avatar--lg bg--primary">
                            <i class="bi bi-credit-card text-white"></i>
                        </div>
                    </div>

                    <div class="card-info text-center">
                        <ul class="user-card-list w-100">
                            <li class="d-flex align-items-center justify-content-between gap-3 mb-2"><span
                                    class="fw-bold">Total Invest</span>
                                <span class="fw-bold text--dark">$3385</span>
                            </li>
                            <li class="d-flex align-items-center justify-content-between gap-3 mb-2"><span
                                    class="fw-bold">Total Profits</span>
                                <span class="fw-bold text--dark">$3225</span>
                            </li>
                            <li class="d-flex align-items-center justify-content-between gap-3 mb-2"><span
                                    class="fw-bold">Running Invest</span>
                                <span class="fw-bold text--dark">$0</span>
                            </li>
                            <li class="d-flex align-items-center justify-content-between gap-3 mb-2"><span
                                    class="fw-bold">Re-invest</span>
                                <span class="fw-bold text--dark">$0</span>
                            </li>
                            <li class="d-flex align-items-center justify-content-between gap-3"><span
                                    class="fw-bold">Closed Invest</span>
                                <span class="fw-bold text--dark">$3385</span>
                            </li>
                        </ul>
                        <a href="../investments.html" class="btn--white">Investment Now<i
                                class="bi bi-box-arrow-up-right ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="i-card-sm">
                <h5 class="title text--blue mb-4">Monthly deposit &amp; withdraw statistics</h5>
                <div id="investProfitChart"></div>
            </div>
        </div>
    </div>

    <div class="i-card-sm mb-4">
        <div class="row g-4">
            <div class="col-12">
                <div class="swiper plan-card-slider">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="card card--design ">
                                <div class="card-body">
                                    <div class="row align-items-end g-3">
                                        <div class="col-8">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar--sm">
                                                    <i class="las la-list-alt fs-24 text--primary"></i>
                                                </div>
                                                <h6 class="ms-2 mb-0 fs-14 text--primary">Starter</h6>
                                            </div>
                                        </div>
                                        <div class="col-6 text-start">
                                            <p class="fs-13 fw-normal text--light">Total Investments</p>
                                            <h6 class="fs-16">$11059</h6>
                                        </div>
                                        <div class="col-6 text-end">
                                            <p class="fs-13 fw-normal text--light">Total Profits</p>
                                            <h6 class="fs-16">$5749</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="i-card-sm">
                <div class="card-header">
                    <h4 class="title">Investment Profits and Commissions</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="filter-area">
                                <form
                                    action="">
                                    <div class="row row-cols-lg-3 row-cols-md-4 row-cols-sm-2 row-cols-1 g-3">
                                        <div class="col">
                                            <input type="text" name="search" placeholder="Trx ID" value="">
                                        </div>
                                        <div class="col">
                                            <input type="text" id="date" class="form-control datepicker-here"
                                                name="date" value="" data-range="true"
                                                data-multiple-dates-separator=" - " data-language="en"
                                                data-position="bottom right" autocomplete="off"
                                                placeholder="Date">
                                        </div>
                                        <div class="col">
                                            <button type="submit" class="i-btn btn--lg btn--primary w-100"><i
                                                    class="bi bi-search me-3"></i>Search</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="table-container">
                                <table id="myTable" class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Initiated At</th>
                                            <th scope="col">Trx</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td data-label="Initiated At">
                                                2024-10-08 06:12 PM
                                            </td>
                                            <td data-label="Trx">
                                                XGH5KU3QS9UU
                                            </td>
                                            <td data-label="Amount">
                                                $50
                                            </td>
                                            <td data-label="Details">
                                                Investment Starter Plan as of 08 Oct 2024 - Earnings: $50
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-label="Initiated At">
                                                2024-10-07 03:08 PM
                                            </td>
                                            <td data-label="Trx">
                                                JFG2ERPTFS2R
                                            </td>
                                            <td data-label="Amount">
                                                $50
                                            </td>
                                            <td data-label="Details">
                                                Investment Starter Plan as of 07 Oct 2024 - Earnings: $50
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-label="Initiated At">
                                                2024-10-06 01:00 AM
                                            </td>
                                            <td data-label="Trx">
                                                PDBCOPVN938Y
                                            </td>
                                            <td data-label="Amount">
                                                $0.4
                                            </td>
                                            <td data-label="Details">
                                                Investment Starter Plan as of 06 Oct 2024 - Earnings: $0.4
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-label="Initiated At">
                                                2024-10-06 12:59 AM
                                            </td>
                                            <td data-label="Trx">
                                                6PMK5M298C64
                                            </td>
                                            <td data-label="Amount">
                                                $0.4
                                            </td>
                                            <td data-label="Details">
                                                Investment Starter Plan as of 06 Oct 2024 - Earnings: $0.4
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-label="Initiated At">
                                                2024-10-06 12:58 AM
                                            </td>
                                            <td data-label="Trx">
                                                CJ1DEVH55N7P
                                            </td>
                                            <td data-label="Amount">
                                                $0.4
                                            </td>
                                            <td data-label="Details">
                                                Investment Starter Plan as of 06 Oct 2024 - Earnings: $0.4
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-label="Initiated At">
                                                2024-10-06 12:57 AM
                                            </td>
                                            <td data-label="Trx">
                                                OF8UXDUO2XDO
                                            </td>
                                            <td data-label="Amount">
                                                $0.4
                                            </td>
                                            <td data-label="Details">
                                                Investment Starter Plan as of 06 Oct 2024 - Earnings: $0.4
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-label="Initiated At">
                                                2024-10-06 12:56 AM
                                            </td>
                                            <td data-label="Trx">
                                                NPARCPPGGQ6S
                                            </td>
                                            <td data-label="Amount">
                                                $0.4
                                            </td>
                                            <td data-label="Details">
                                                Investment Starter Plan as of 06 Oct 2024 - Earnings: $0.4
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-label="Initiated At">
                                                2024-10-06 12:55 AM
                                            </td>
                                            <td data-label="Trx">
                                                XF26RZ953SRO
                                            </td>
                                            <td data-label="Amount">
                                                $0.4
                                            </td>
                                            <td data-label="Details">
                                                Investment Starter Plan as of 06 Oct 2024 - Earnings: $0.4
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-label="Initiated At">
                                                2024-10-06 12:54 AM
                                            </td>
                                            <td data-label="Trx">
                                                N6ZGHY952NZM
                                            </td>
                                            <td data-label="Amount">
                                                $0.4
                                            </td>
                                            <td data-label="Details">
                                                Investment Starter Plan as of 06 Oct 2024 - Earnings: $0.4
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-label="Initiated At">
                                                2024-10-06 12:53 AM
                                            </td>
                                            <td data-label="Trx">
                                                GTC1NRPZESK4
                                            </td>
                                            <td data-label="Amount">
                                                $0.4
                                            </td>
                                            <td data-label="Details">
                                                Investment Starter Plan as of 06 Oct 2024 - Earnings: $0.4
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-label="Initiated At">
                                                2024-10-06 12:52 AM
                                            </td>
                                            <td data-label="Trx">
                                                ZN97TB4AVNEH
                                            </td>
                                            <td data-label="Amount">
                                                $0.4
                                            </td>
                                            <td data-label="Details">
                                                Investment Starter Plan as of 06 Oct 2024 - Earnings: $0.4
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-label="Initiated At">
                                                2024-10-06 12:51 AM
                                            </td>
                                            <td data-label="Trx">
                                                1G6SZ6ZCEE5C
                                            </td>
                                            <td data-label="Amount">
                                                $0.4
                                            </td>
                                            <td data-label="Details">
                                                Investment Starter Plan as of 06 Oct 2024 - Earnings: $0.4
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-label="Initiated At">
                                                2024-10-06 12:50 AM
                                            </td>
                                            <td data-label="Trx">
                                                6M9JDXGFRC3B
                                            </td>
                                            <td data-label="Amount">
                                                $0.4
                                            </td>
                                            <td data-label="Details">
                                                Investment Starter Plan as of 06 Oct 2024 - Earnings: $0.4
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-label="Initiated At">
                                                2024-10-06 12:49 AM
                                            </td>
                                            <td data-label="Trx">
                                                STB1B5SG7W63
                                            </td>
                                            <td data-label="Amount">
                                                $0.4
                                            </td>
                                            <td data-label="Details">
                                                Investment Starter Plan as of 06 Oct 2024 - Earnings: $0.4
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-label="Initiated At">
                                                2024-10-06 12:48 AM
                                            </td>
                                            <td data-label="Trx">
                                                PKWY4XTNRTBM
                                            </td>
                                            <td data-label="Amount">
                                                $0.4
                                            </td>
                                            <td data-label="Details">
                                                Investment Starter Plan as of 06 Oct 2024 - Earnings: $0.4
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-label="Initiated At">
                                                2024-10-06 12:47 AM
                                            </td>
                                            <td data-label="Trx">
                                                YK7SYBTOP5OR
                                            </td>
                                            <td data-label="Amount">
                                                $0.4
                                            </td>
                                            <td data-label="Details">
                                                Investment Starter Plan as of 06 Oct 2024 - Earnings: $0.4
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-label="Initiated At">
                                                2024-10-06 12:46 AM
                                            </td>
                                            <td data-label="Trx">
                                                FYDKPKXKN55A
                                            </td>
                                            <td data-label="Amount">
                                                $0.4
                                            </td>
                                            <td data-label="Details">
                                                Investment Starter Plan as of 06 Oct 2024 - Earnings: $0.4
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-label="Initiated At">
                                                2024-10-06 12:45 AM
                                            </td>
                                            <td data-label="Trx">
                                                7CE2OKH2YBUZ
                                            </td>
                                            <td data-label="Amount">
                                                $0.4
                                            </td>
                                            <td data-label="Details">
                                                Investment Starter Plan as of 06 Oct 2024 - Earnings: $0.4
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-label="Initiated At">
                                                2024-10-06 12:44 AM
                                            </td>
                                            <td data-label="Trx">
                                                4NSKADBY95NE
                                            </td>
                                            <td data-label="Amount">
                                                $0.4
                                            </td>
                                            <td data-label="Details">
                                                Investment Starter Plan as of 06 Oct 2024 - Earnings: $0.4
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-label="Initiated At">
                                                2024-10-06 12:43 AM
                                            </td>
                                            <td data-label="Trx">
                                                CSR41DNUORDF
                                            </td>
                                            <td data-label="Amount">
                                                $0.4
                                            </td>
                                            <td data-label="Details">
                                                Investment Starter Plan as of 06 Oct 2024 - Earnings: $0.4
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <nav class="d-flex justify-items-center justify-content-between">
                    <div class="d-flex justify-content-between flex-fill d-sm-none">
                        <ul class="pagination">

                            <li class="page-item">
                                <a class="page-link" href="profit-statistics-7.html?page=1" rel="prev">&laquo;
                                    Previous</a>
                            </li>


                            <li class="page-item">
                                <a class="page-link" href="profit-statistics-2.html?page=3" rel="next">Next
                                    &raquo;</a>
                            </li>
                        </ul>
                    </div>

                    <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
                        <div>
                            <p class="small text-muted">
                                Showing
                                <span class="fw-semibold">21</span>
                                to
                                <span class="fw-semibold">40</span>
                                of
                                <span class="fw-semibold">122</span>
                                results
                            </p>
                        </div>

                        <div>
                            <ul class="pagination">

                                <li class="page-item">
                                    <a class="page-link" href="profit-statistics-7.html?page=1" rel="prev"
                                        aria-label="&laquo; Previous">&lsaquo;</a>
                                </li>





                                <li class="page-item"><a class="page-link"
                                        href="profit-statistics-7.html?page=1">1</a></li>
                                <li class="page-item active" aria-current="page"><span
                                        class="page-link">2</span></li>
                                <li class="page-item"><a class="page-link"
                                        href="profit-statistics-2.html?page=3">3</a></li>
                                <li class="page-item"><a class="page-link"
                                        href="profit-statistics-3.html?page=4">4</a></li>
                                <li class="page-item"><a class="page-link"
                                        href="profit-statistics-4.html?page=5">5</a></li>
                                <li class="page-item"><a class="page-link"
                                        href="profit-statistics-5.html?page=6">6</a></li>
                                <li class="page-item"><a class="page-link"
                                        href="profit-statistics-6.html?page=7">7</a></li>


                                <li class="page-item">
                                    <a class="page-link" href="profit-statistics-2.html?page=3" rel="next"
                                        aria-label="Next &raquo;">&rsaquo;</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>