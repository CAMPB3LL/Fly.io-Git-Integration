# go-example

A minimal Go application for [fly.io Getting Started](https://fly.io/docs/getting-started/golang/) documentation and tutorials.

To get started:

1. clone this repo
2. `flyctl launch`
3. view the deployed app with flyctl open

## Git Continous Deployment

1. Fork the go-example repository to your GitHub account.
2. Clone the new repository to your local machine.
3. Run fly launch from within the project source directory to create a new app and a fly.toml configuration file. Type N when fly launch asks if you want to set up databases and N when it asks if you want to deploy.
4. Still in the project source directory, get a Fly API deploy token by running fly tokens create deploy -x 999999h. Copy the output.
5. Go to your newly-created repository on GitHub and select Settings.
6. Under Secrets and variables, select Actions, and then create a new repository secret called FLY_API_TOKEN with the value of the token from step 4.
7. Back in your project source directory, create .github/workflows/fly.yml with these contents:

```
name: Fly Deploy
on:
  push:
    branches:
      - master
jobs:
  deploy:
    name: Deploy app
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
      - uses: superfly/flyctl-actions/setup-flyctl@master
      - run: flyctl deploy --remote-only
        env:
          FLY_API_TOKEN: ${{ secrets.FLY_API_TOKEN }}
```
Note that the go-example’s default branch is currently master. If you’re using a different app, yours might be main. Change the fly.yml file accordingly.

8. Commit your changes and push them up to GitHub. You should be pushing two new files: fly.toml, the Fly Launch configuration file, and fly.yml, the GitHub action file.
