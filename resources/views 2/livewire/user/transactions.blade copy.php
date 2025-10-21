<div class="main-content" data-simplebar="">
    <div class="row">
      <div class="col-lg-12">
        <div class="i-card-sm mb-4">
          <div class="card-header">
            <h4 class="title">Transactions</h4>
          </div>
          <div class="filter-area">
            <form
              action=""
            >
              <div
                class="row row-cols-lg-4 row-cols-md-4 row-cols-sm-2 row-cols-1 g-3"
              >
                <div class="col">
                  <input
                    type="text"
                    name="search"
                    placeholder="Trx ID"
                    value=""
                  />
                </div>
                <div class="col">
                  <select class="select2-js" name="wallet_type">
                    <option value="1">PRIMARY</option>
                    <option value="2">INVESTMENT</option>
                    <option value="3">TRADE</option>
                  </select>
                </div>
                <div class="col">
                  <select class="select2-js" name="source">
                    <option value="1">ALL</option>
                    <option value="2">MATRIX</option>
                    <option value="3">INVESTMENT</option>
                    <option value="4">TRADE</option>
                  </select>
                </div>
                <div class="col">
                  <input
                    type="text"
                    id="date"
                    class="form-control datepicker-here"
                    name="date"
                    value=""
                    data-range="true"
                    data-multiple-dates-separator=" - "
                    data-language="en"
                    data-position="bottom right"
                    autocomplete="off"
                    placeholder="Date"
                  />
                </div>
                <div class="col">
                  <button
                    type="submit"
                    class="i-btn btn--lg btn--primary w-100"
                  >
                    <i class="bi bi-search me-3"></i>Search
                  </button>
                </div>
              </div>
            </form>
          </div>

          <div class="card-body">
            <div class="row align-items-center gy-4 mb-3">
              <div class="table-container">
                <table id="myTable" class="table">
                  <thead>
                    <tr>
                      <th scope="col">Initiated At</th>
                      <th scope="col">Trx</th>
                      <th scope="col">Amount</th>
                      <th scope="col">Post Balance</th>
                      <th scope="col">Charge</th>
                      <th scope="col">Source</th>
                      <th scope="col">Wallet</th>
                      <th scope="col">Details</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td data-label="Initiated At">2024-10-26 01:56 AM</td>
                      <td data-label="Trx">UB1HPYZQ9KDT</td>
                      <td data-label="Amount">
                        <span class="text--danger"> $100 </span>
                      </td>
                      <td data-label="Post Balance">
                        Primary Balance : $1418
                      </td>
                      <td data-label="Charge">$0</td>
                      <td data-label="Source">
                        <span class="i-badge badge--primary"> All </span>
                      </td>
                      <td data-label="Wallet">
                        <span class="i-badge badge--primary">
                          Primary Wallet
                        </span>
                      </td>
                      <td data-label="Details">
                        Generate an E-pin worth $100
                      </td>
                    </tr>
                    <tr>
                      <td data-label="Initiated At">2024-10-26 01:55 AM</td>
                      <td data-label="Trx">RHJ1NBZUO5RK</td>
                      <td data-label="Amount">
                        <span class="text--danger"> $1000 </span>
                      </td>
                      <td data-label="Post Balance">
                        Investment Balance : $1261.95
                      </td>
                      <td data-label="Charge">$0</td>
                      <td data-label="Source">
                        <span class="i-badge badge--primary"> All </span>
                      </td>
                      <td data-label="Wallet">
                        <span class="i-badge badge--success">
                          Investment Wallet
                        </span>
                      </td>
                      <td data-label="Details">
                        Reduced Investment Balance by $1000 added to primary
                        account
                      </td>
                    </tr>
                    <tr>
                      <td data-label="Initiated At">2024-10-26 01:55 AM</td>
                      <td data-label="Trx">UKTQ6PHC6SX8</td>
                      <td data-label="Amount">
                        <span class="text--success"> $1000 </span>
                      </td>
                      <td data-label="Post Balance">
                        Primary Balance : $1518
                      </td>
                      <td data-label="Charge">$0</td>
                      <td data-label="Source">
                        <span class="i-badge badge--primary"> All </span>
                      </td>
                      <td data-label="Wallet">
                        <span class="i-badge badge--primary">
                          Primary Wallet
                        </span>
                      </td>
                      <td data-label="Details">
                        $1000 was added to the primary balance from the
                        Investment Balance
                      </td>
                    </tr>
                    <tr>
                      <td data-label="Initiated At">2024-10-26 01:55 AM</td>
                      <td data-label="Trx">7VPJRVD2XBOW</td>
                      <td data-label="Amount">
                        <span class="text--danger"> $100 </span>
                      </td>
                      <td data-label="Post Balance">
                        Investment Balance : $2261.95
                      </td>
                      <td data-label="Charge">$0</td>
                      <td data-label="Source">
                        <span class="i-badge badge--primary"> All </span>
                      </td>
                      <td data-label="Wallet">
                        <span class="i-badge badge--success">
                          Investment Wallet
                        </span>
                      </td>
                      <td data-label="Details">
                        Reduced Investment Balance by $100 added to primary
                        account
                      </td>
                    </tr>
                    <tr>
                      <td data-label="Initiated At">2024-10-26 01:55 AM</td>
                      <td data-label="Trx">TXFEMSWYTUSE</td>
                      <td data-label="Amount">
                        <span class="text--success"> $100 </span>
                      </td>
                      <td data-label="Post Balance">
                        Primary Balance : $518
                      </td>
                      <td data-label="Charge">$0</td>
                      <td data-label="Source">
                        <span class="i-badge badge--primary"> All </span>
                      </td>
                      <td data-label="Wallet">
                        <span class="i-badge badge--primary">
                          Primary Wallet
                        </span>
                      </td>
                      <td data-label="Details">
                        $100 was added to the primary balance from the
                        Investment Balance
                      </td>
                    </tr>
                    <tr>
                      <td data-label="Initiated At">2024-10-25 04:48 AM</td>
                      <td data-label="Trx">38B8G3J9J1M1</td>
                      <td data-label="Amount">
                        <span class="text--danger"> $50 </span>
                      </td>
                      <td data-label="Post Balance">
                        Primary Balance : $418
                      </td>
                      <td data-label="Charge">$0</td>
                      <td data-label="Source">
                        <span class="i-badge badge--primary"> All </span>
                      </td>
                      <td data-label="Wallet">
                        <span class="i-badge badge--primary">
                          Primary Wallet
                        </span>
                      </td>
                      <td data-label="Details">
                        Generate an E-pin worth $50
                      </td>
                    </tr>
                    <tr>
                      <td data-label="Initiated At">2024-10-25 04:45 AM</td>
                      <td data-label="Trx">ZTGV8M7XXAUN</td>
                      <td data-label="Amount">
                        <span class="text--success"> $50 </span>
                      </td>
                      <td data-label="Post Balance">
                        Investment Balance : $2361.95
                      </td>
                      <td data-label="Charge">$0</td>
                      <td data-label="Source">
                        <span class="i-badge badge--success">
                          Investment
                        </span>
                      </td>
                      <td data-label="Wallet">
                        <span class="i-badge badge--success">
                          Investment Wallet
                        </span>
                      </td>
                      <td data-label="Details">
                        $50 capital back from Starter
                      </td>
                    </tr>
                    <tr>
                      <td data-label="Initiated At">2024-10-25 04:45 AM</td>
                      <td data-label="Trx">THXXTF8J9543</td>
                      <td data-label="Amount">
                        <span class="text--success"> $50 </span>
                      </td>
                      <td data-label="Post Balance">
                        Investment Balance : $2311.95
                      </td>
                      <td data-label="Charge">$0</td>
                      <td data-label="Source">
                        <span class="i-badge badge--success">
                          Investment
                        </span>
                      </td>
                      <td data-label="Wallet">
                        <span class="i-badge badge--success">
                          Investment Wallet
                        </span>
                      </td>
                      <td data-label="Details">
                        Investment Starter Plan as of 25 Oct 2024 -
                        Earnings: $50
                      </td>
                    </tr>
                    <tr>
                      <td data-label="Initiated At">2024-10-25 04:44 AM</td>
                      <td data-label="Trx">ZT4T8J137EDA</td>
                      <td data-label="Amount">
                        <span class="text--danger"> $50 </span>
                      </td>
                      <td data-label="Post Balance">
                        Primary Balance : $468
                      </td>
                      <td data-label="Charge">$0</td>
                      <td data-label="Source">
                        <span class="i-badge badge--success">
                          Investment
                        </span>
                      </td>
                      <td data-label="Wallet">
                        <span class="i-badge badge--primary">
                          Primary Wallet
                        </span>
                      </td>
                      <td data-label="Details">
                        $50 invested in the Starter plan for a duration of 1
                        days
                      </td>
                    </tr>
                    <tr>
                      <td data-label="Initiated At">2024-10-23 10:36 PM</td>
                      <td data-label="Trx">M6OVKEBQ36ZG</td>
                      <td data-label="Amount">
                        <span class="text--success"> $100 </span>
                      </td>
                      <td data-label="Post Balance">
                        Investment Balance : $2261.95
                      </td>
                      <td data-label="Charge">$0</td>
                      <td data-label="Source">
                        <span class="i-badge badge--success">
                          Investment
                        </span>
                      </td>
                      <td data-label="Wallet">
                        <span class="i-badge badge--success">
                          Investment Wallet
                        </span>
                      </td>
                      <td data-label="Details">
                        $100 capital back from Starter
                      </td>
                    </tr>
                    <tr>
                      <td data-label="Initiated At">2024-10-23 10:36 PM</td>
                      <td data-label="Trx">PBB94CB41ZTR</td>
                      <td data-label="Amount">
                        <span class="text--success"> $100 </span>
                      </td>
                      <td data-label="Post Balance">
                        Investment Balance : $2161.95
                      </td>
                      <td data-label="Charge">$0</td>
                      <td data-label="Source">
                        <span class="i-badge badge--success">
                          Investment
                        </span>
                      </td>
                      <td data-label="Wallet">
                        <span class="i-badge badge--success">
                          Investment Wallet
                        </span>
                      </td>
                      <td data-label="Details">
                        Investment Starter Plan as of 23 Oct 2024 -
                        Earnings: $100
                      </td>
                    </tr>
                    <tr>
                      <td data-label="Initiated At">2024-10-23 10:35 PM</td>
                      <td data-label="Trx">3ZPV5K7BBV23</td>
                      <td data-label="Amount">
                        <span class="text--danger"> $100 </span>
                      </td>
                      <td data-label="Post Balance">
                        Primary Balance : $518
                      </td>
                      <td data-label="Charge">$0</td>
                      <td data-label="Source">
                        <span class="i-badge badge--success">
                          Investment
                        </span>
                      </td>
                      <td data-label="Wallet">
                        <span class="i-badge badge--primary">
                          Primary Wallet
                        </span>
                      </td>
                      <td data-label="Details">
                        $100 invested in the Starter plan for a duration of
                        1 days
                      </td>
                    </tr>
                    <tr>
                      <td data-label="Initiated At">2024-10-23 09:16 PM</td>
                      <td data-label="Trx">8N74MZPHZY9P</td>
                      <td data-label="Amount">
                        <span class="text--success"> $60 </span>
                      </td>
                      <td data-label="Post Balance">
                        Investment Balance : $2061.95
                      </td>
                      <td data-label="Charge">$0</td>
                      <td data-label="Source">
                        <span class="i-badge badge--success">
                          Investment
                        </span>
                      </td>
                      <td data-label="Wallet">
                        <span class="i-badge badge--success">
                          Investment Wallet
                        </span>
                      </td>
                      <td data-label="Details">
                        $60 capital back from Starter
                      </td>
                    </tr>
                    <tr>
                      <td data-label="Initiated At">2024-10-23 09:16 PM</td>
                      <td data-label="Trx">SWXXZ7G1XO3Z</td>
                      <td data-label="Amount">
                        <span class="text--success"> $60 </span>
                      </td>
                      <td data-label="Post Balance">
                        Investment Balance : $2001.95
                      </td>
                      <td data-label="Charge">$0</td>
                      <td data-label="Source">
                        <span class="i-badge badge--success">
                          Investment
                        </span>
                      </td>
                      <td data-label="Wallet">
                        <span class="i-badge badge--success">
                          Investment Wallet
                        </span>
                      </td>
                      <td data-label="Details">
                        Investment Starter Plan as of 23 Oct 2024 -
                        Earnings: $60
                      </td>
                    </tr>
                    <tr>
                      <td data-label="Initiated At">2024-10-23 09:15 PM</td>
                      <td data-label="Trx">ZH3MHTNU7U9G</td>
                      <td data-label="Amount">
                        <span class="text--danger"> $60 </span>
                      </td>
                      <td data-label="Post Balance">
                        Primary Balance : $618
                      </td>
                      <td data-label="Charge">$0</td>
                      <td data-label="Source">
                        <span class="i-badge badge--success">
                          Investment
                        </span>
                      </td>
                      <td data-label="Wallet">
                        <span class="i-badge badge--primary">
                          Primary Wallet
                        </span>
                      </td>
                      <td data-label="Details">
                        $60 invested in the Starter plan for a duration of 1
                        days
                      </td>
                    </tr>
                    <tr>
                      <td data-label="Initiated At">2024-10-23 09:15 PM</td>
                      <td data-label="Trx">1T9U98TRY1SG</td>
                      <td data-label="Amount">
                        <span class="text--success"> $120 </span>
                      </td>
                      <td data-label="Post Balance">
                        Investment Balance : $1941.95
                      </td>
                      <td data-label="Charge">$0</td>
                      <td data-label="Source">
                        <span class="i-badge badge--success">
                          Investment
                        </span>
                      </td>
                      <td data-label="Wallet">
                        <span class="i-badge badge--success">
                          Investment Wallet
                        </span>
                      </td>
                      <td data-label="Details">
                        $120 capital back from Starter
                      </td>
                    </tr>
                    <tr>
                      <td data-label="Initiated At">2024-10-23 09:15 PM</td>
                      <td data-label="Trx">UKSV4115N7TE</td>
                      <td data-label="Amount">
                        <span class="text--success"> $120 </span>
                      </td>
                      <td data-label="Post Balance">
                        Investment Balance : $1821.95
                      </td>
                      <td data-label="Charge">$0</td>
                      <td data-label="Source">
                        <span class="i-badge badge--success">
                          Investment
                        </span>
                      </td>
                      <td data-label="Wallet">
                        <span class="i-badge badge--success">
                          Investment Wallet
                        </span>
                      </td>
                      <td data-label="Details">
                        Investment Starter Plan as of 23 Oct 2024 -
                        Earnings: $120
                      </td>
                    </tr>
                    <tr>
                      <td data-label="Initiated At">2024-10-23 09:14 PM</td>
                      <td data-label="Trx">229VE53O7RNP</td>
                      <td data-label="Amount">
                        <span class="text--danger"> $120 </span>
                      </td>
                      <td data-label="Post Balance">
                        Primary Balance : $678
                      </td>
                      <td data-label="Charge">$0</td>
                      <td data-label="Source">
                        <span class="i-badge badge--success">
                          Investment
                        </span>
                      </td>
                      <td data-label="Wallet">
                        <span class="i-badge badge--primary">
                          Primary Wallet
                        </span>
                      </td>
                      <td data-label="Details">
                        $120 invested in the Starter plan for a duration of
                        1 days
                      </td>
                    </tr>
                    <tr>
                      <td data-label="Initiated At">2024-10-23 09:11 PM</td>
                      <td data-label="Trx">H86PJF4NEQ91</td>
                      <td data-label="Amount">
                        <span class="text--success"> $50 </span>
                      </td>
                      <td data-label="Post Balance">
                        Investment Balance : $1701.95
                      </td>
                      <td data-label="Charge">$0</td>
                      <td data-label="Source">
                        <span class="i-badge badge--success">
                          Investment
                        </span>
                      </td>
                      <td data-label="Wallet">
                        <span class="i-badge badge--success">
                          Investment Wallet
                        </span>
                      </td>
                      <td data-label="Details">
                        $50 capital back from Starter
                      </td>
                    </tr>
                    <tr>
                      <td data-label="Initiated At">2024-10-23 09:11 PM</td>
                      <td data-label="Trx">9S9MKJYF5POT</td>
                      <td data-label="Amount">
                        <span class="text--success"> $50 </span>
                      </td>
                      <td data-label="Post Balance">
                        Investment Balance : $1651.95
                      </td>
                      <td data-label="Charge">$0</td>
                      <td data-label="Source">
                        <span class="i-badge badge--success">
                          Investment
                        </span>
                      </td>
                      <td data-label="Wallet">
                        <span class="i-badge badge--success">
                          Investment Wallet
                        </span>
                      </td>
                      <td data-label="Details">
                        Investment Starter Plan as of 23 Oct 2024 -
                        Earnings: $50
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

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
        </div>
      </div>
    </div>
  </div>