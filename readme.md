E-Trade

The mission of this project is to allow users to manage a portfolio of stocks.
Each user receives $10,000 upon registration which s/he will be able to invest.
Additional features include search options, statistics and history.

The application harvests data from the yahoo.finance API:
https://code.google.com/p/yahoo-finance-managed/wiki/YahooFinanceAPIs

Unfinished Functionality:
- Transaction History needs to be rewritten.
- Statistics page.
- Front page UX

Known Bugs:
- Error handling fails if connection to Yahoo! API is lost during portfolio_view loop.
- DB connection randomly fails on first login attempt 

Notes:
- Little (amount of) JavaScript will be implemented to this project to achieve little reliance on client side functionality.
  Client side form validation will only be added to reduce server load.
- Scalability: As the SQL schema suggests, this model focuses on staying small and portable.
  This, in result, will cause slower querying on larger scale implementations.
