# temp1

- PHP version is not defined
- No Code style policy is required
- No Error behaviour policy is described
- No Logging policy is described
- No env requirents

That's why:
- Version 8.2 is selected
- No PSR used
- Banner is returned in any way (even when error happen)
- Default file with errors is used
- No tests
- No Docker image

All configs stored in env file for easier running service under container with passing configs to it.

If no microservice is used, than do not see reasons to build complex structures (classes)

## Installation

1. Copy .env.example to .env
2. Configure virtual host or just copy to directory of configured localhost - limit web access only to "public" directory
3. Import dump.sql
